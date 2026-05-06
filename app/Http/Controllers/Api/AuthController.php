<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function userRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => ['required', 'regex:/^01[0-9]{9}$/', 'unique:users,phone'],
                'email' => 'nullable|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all(),
                ], 422);
            }

            DB::beginTransaction();

            $customer = new User();
            $customer->name = $request->name;
            $customer->slug = Str::slug($request->name . '-' . uniqid());
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->password = bcrypt($request->password);
            // $customer->verify = 1;
            $customer->status = 1;
            $customer->save();

            $token = $customer->createToken('authToken')->plainTextToken;

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User Registered Successfully!',
                'token' => $token,
                'user' => $customer,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function userLogin(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'login' => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,

                    'message' => $validator->errors()->all(),

                ], 422);
            }

            $login = $request->login;

            $user = User::where('phone', $login)
                ->orWhere('email', $login)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sorry! No account found',
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credential.',
                ], 401);
            }

            // $user->tokens()->delete();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful!',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function userLogout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logout successful!',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function vendorLogin()
    {

        $link = route('vendor.login');
        return response()->json([
            'status' => true,
            'message' => 'Vendor login endpoint',
            'link' => route('vendor.login'),
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }
}
