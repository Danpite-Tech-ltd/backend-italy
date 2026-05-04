<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.pages.profile.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $request->validate([
            'name'           => ['required','string','max:255'],
            'email'          => ['required','string','email','max:255'],
            // 'phone'          => ['required','string','max:255','unique:users,phone'],
            'address'        => ['nullable','string','max:255'],
            'profile_image'  => ['nullable','image','max:255','mimes:jpeg,png,jpg,gif,svg|max:2048']
        ]);



        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->password = $request->change_password ? bcrypt($request->change_password) : $user->password;

        }

        if($request->hasFile('profile_image')){
            if($user->profile_image && file_exists($user->profile_image)){
                unlink($user->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/profile/', $filename);
            $user->profile_image = 'public/admin/upload/profile/' . $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
