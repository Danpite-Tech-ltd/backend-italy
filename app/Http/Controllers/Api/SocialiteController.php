<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Socialite;

class SocialiteController extends Controller
{
    public function google_redirect()
    {
        return Socialite::driver('google')
        ->stateless()
        ->redirect();
    }

    public function google_callback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            // Email check
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {

                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful!',
                    'token' => $token,
                    'user' => $user,
                ], 200);
            }

            // if not registration
            DB::beginTransaction();

            $user = new User();
            $user->name = $googleUser->name;
            $user->slug = Str::slug($googleUser->name . '-' . uniqid());
            $user->email = $googleUser->email;
            $user->phone = null;

            // random password
            $user->password = bcrypt(Str::random(16));
            $user->status = 1;

            $user->save();

            $token = $user->createToken('authToken')->plainTextToken;

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User registered & login successful!',
                'token' => $token,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Google login failed!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
