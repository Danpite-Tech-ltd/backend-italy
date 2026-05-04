<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\BankSetup;
use App\Models\City;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        $countries = Country::all();
        return view('vendor.auth.register', compact('countries'));
    }

    public function getCity(Request $request)
    {
        $str = '<option value="">Select City*</option>';
        $cities = City::where('country_id', $request->country_id)->get();

        foreach ($cities as $city) {
            $str .= '<option value=' . $city->id . '>' . $city->name . '</option>';
        }
        echo $str;
    }

    public function register_submit(Request $request)
    {
        $request->validate([
            'first_name'        => 'required|string|max:255',
            'phone'             => 'required|string|max:20|unique:vendors,phone',
            'email'             => 'required|email|unique:vendors,email',
            'company_name'      => 'required|string|max:255',
            'company_address'   => 'required|string|max:255',
            'country'           => 'required|string',
            'city'              => 'required|string',
            'post_code'         => 'required|string|max:20',
            'password'          => 'required|confirmed|min:6',
        ]);

        $vendor = new Vendor();
        $vendor->first_name      = $request->first_name;
        $vendor->last_name       = $request->last_name;
        $vendor->phone           = $request->phone;
        $vendor->email           = $request->email;
        $vendor->company_name    = $request->company_name;
        $vendor->company_address = $request->company_address;
        $vendor->country         = Country::find($request->country)->name;
        $vendor->city            = City::find($request->city)->name;
        $vendor->post_code       = $request->post_code;
        $vendor->password        = bcrypt($request->password);
        $vendor->save();

        BankSetup::create([
            'vendor_id' => $vendor->id
        ]);

        return redirect()->back()->with('success', 'Vendor registered successfully! Please wait for admin approval.');

    }

    public function login()
    {
        return view('vendor.auth.login');
    }


    public function login_submit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Vendor::where('email', $request->email)->exists()) {
            if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if(Auth::guard('vendor')->user()->status == 'approved'){
                    return redirect()->route('vendor.dashboard');
                }else{
                    return back()->with('pending', 'Your account is pending. Please contact support.');
                }
            } else {
                return back()->with('wrong', 'Wrong Credential!');
            }
        } else {
            return back()->with('exists', 'Email Does not exists!');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }

    public function profile()
    {
        $user = Auth::guard('vendor')->user();
        return view('vendor.pages.profile.index', compact('user'));
    }

    public function profile_update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        // Validation
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email',
            'company_name'   => 'nullable|string|max:255',
            'address'        => 'nullable|string',
            'country'        => 'nullable|string|max:255',
            'city'           => 'nullable|string|max:255',
        ]);

        // Update Basic Info
        $vendor->first_name       = $request->first_name;
        $vendor->last_name        = $request->last_name;
        $vendor->phone            = $request->phone;
        $vendor->email            = $request->email;
        $vendor->company_name     = $request->company_name;
        $vendor->company_address  = $request->address; // textarea = address
        $vendor->country          = $request->country;
        $vendor->city             = $request->city;
        $vendor->post_code        = $request->post_code;
        $vendor->password = $request->change_password ? bcrypt($request->change_password) : $vendor->password;


        if ($request->hasFile('profile_image')) {

            if ($vendor->profile_image && file_exists(public_path($vendor->profile_image))) {
                unlink(public_path($vendor->profile_image));
            }

            $file       = $request->file('profile_image');
            $filename   = time() . '_' . $file->getClientOriginalName();
            $path       = 'public/vendor/uploads/profile/' . $filename;

            $file->move(public_path('vendor/uploads/profile'), $filename);

            $vendor->profile_image = $path;
        }

        $vendor->update();

        return back()->with('success', 'Profile updated successfully!');
    }


    public function dashboard()
    {
        return view('vendor.dashboard');
    }
}
