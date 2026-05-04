<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View User', only: ['index']),
            new Middleware('permission:Create User', only: ['store', 'create']),
            new Middleware('permission:Edit User', only: ['update', 'edit']),
            new Middleware('permission:Delete User', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $admins = User::role('user');

            return DataTables::eloquent($admins)
                ->addColumn('role', function ($admin) {
                    $role = $admin->getRoleNames();
//                $string = implode(',', $role);

                    if (count($role)) {
                        return '<label class="badge badge-success">' . $role[0] . '</label>';
                    }
                    return '';
                })
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if ($admin->id != 1) {
                        if (Auth::user()->can('Edit User')) {
                            $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                        }

                        if (Auth::user()->can('Delete User')) {
                            $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                        }

                        return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                    }
                })
                ->rawColumns(['action', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);


        }
        $roles = Role::get();
        return view('admin.pages.user.index', compact('roles'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->slug = Str::slug($request->name) . uniqid();
        $admin->email = $request->email;
        $admin->password = $request->password;

        $admin->syncRoles($request->role);

        if ($request->hasFile('profile_image')) {

            $file = $request->file('profile_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/upload/user/'), $filename);
            $admin->profile_image = 'public/admin/upload/user/' . $filename;

        }

        $save = $admin->save();

        if ($save) {
            return response()->json(['status' => 'success', 'message' => 'User created successfully'], 201);
        }

        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
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
        $roles = Role::get();
        $admin = User::with('roles')->findOrFail($id);


        if ($admin) {
            return response()->json(['status' => 'success', 'message' => 'User fetched successfully', 'data' => $admin, 'roles' => $roles], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

//        dd($request->all());
        $admin = User::findOrFail($id);

        if ($admin) {
            $admin->name = $request->name;
            $admin->email = $request->email;


            $admin->syncRoles($request->role);

            if ($request->hasFile('profile_image')) {
                if ($admin->profile_image && file_exists($admin->profile_image)) {
                    unlink($admin->profile_image);
                }
                $file = $request->file('profile_image');
                $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('admin/upload/user/'), $filename);
                $admin->profile_image = 'public/admin/upload/user/' . $filename;
            }

            $save = $admin->save();

            if ($save) {
                return response()->json(['status' => 'success', 'message' => 'User Updated successfully'], 200);
            }
        }


        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);

        if ($admin) {
            $admin->delete();

            return response()->json(['status' => 'success', 'message' => 'User has been Deleted successfully'], 200);
        }
        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }
}
