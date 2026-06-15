<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
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
        $url = BasicInfo::first()->website_url;
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            // Email check
            $user = User::where('email', $googleUser->email)->first();

            // Existing User Login
            if ($user) {

                $token = $user->createToken('authToken')->plainTextToken;

                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'slug' => $user->slug,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'status' => $user->status,
                ];

                return redirect()->to(
                    $url.'/auth/google/callback?' .
                        'token=' . urlencode($token) .
                        '&user=' . urlencode(json_encode($userData))
                );
            }

            // New Registration
            DB::beginTransaction();

            $user = new User();
            $user->name = $googleUser->name;
            $user->slug = Str::slug($googleUser->name . '-' . uniqid());
            $user->email = $googleUser->email;
            $user->phone = null;

            // Random password
            $user->password = bcrypt(Str::random(16));
            $user->status = 1;

            $user->save();

            $token = $user->createToken('authToken')->plainTextToken;

            DB::commit();

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'slug' => $user->slug,
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => $user->status,
            ];

            return redirect()->to(
                $url.'/auth/google/callback?' .
                    'token=' . urlencode($token) .
                    '&user=' . urlencode(json_encode($userData))
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->to(
                $url.'/auth/google/callback?' .
                    'error=' . urlencode($e->getMessage())
            );
        }
    }
}
