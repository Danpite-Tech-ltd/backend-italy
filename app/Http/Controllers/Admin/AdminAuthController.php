<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
//      dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required','email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withInput()->with('error', 'The provided credentials do not match our records.');

        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // ✅ Check if user has permission
            if ($user->can('Admin Dashboard')) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard', absolute: false))->with('success','You have successfully logged in.');
            }

            // ❌ No permission → log out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();


            return redirect()
                ->route('admin.login')
                ->withInput()
                ->with('error', 'You do not have permission to access the dashboard.');
        }

        // ❌ Invalid credentials
        return back()->withInput()->with('error','The provided credentials do not match our records.');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}
