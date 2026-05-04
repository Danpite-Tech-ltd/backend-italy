<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Role', only: ['index']),
            new Middleware('permission:Create Role', only: ['store', 'create']),
            new Middleware('permission:Edit Role', only: ['update', 'edit']),
            new Middleware('permission:Delete Role', only: ['destroy']),
            new Middleware('permission:Assign Permission', only: ['assignPermissionsToRolePage', 'assignPermissionsToRole']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $roles = Role::with('permissions');
            return DataTables::eloquent($roles)
                ->addColumn('permissions', function ($role) {
                    $perp_names = $role->permissions->pluck('name');
                    $badge = '';
                    foreach ($perp_names as $perm) {
                        $badge .= '<span class="badge bg-success p-1 mx-1 my-1">' . $perm . '</span>';
                    }
                    return $badge;
                })
                ->addColumn('action', function ($role) {
                    $addPermission = route('admin.role.assign-permissions-page', $role->id);

                    $addPerAction = '';
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Assign Permission')) {
                        $addPerAction = '<a class="btn btn-sm btn-primary" href="' . $addPermission . '"><i class="fa-solid fa-user-plus"></i></a> ';
                    }
                    if (Auth::user()->can('Edit Role')) {
                        $editAction = '<a class="editButton btn btn-sm btn-primary" href="javascript:void(0)" data-id="' . $role->id . '" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Role')) {

                    $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" data-id="' . $role->id . '" id="deleteRoleBtn""> <i class="fas fa-trash"></i></a>';
                    }

                    if ($role->id == 1 || $role->id == 2 || $role->id == 3 || $role->id == 4) {
                        $addPerAction = '';
                        $editAction = '';
                        $deleteAction = '';
                    }

                    return '<div class="d-flex gap-3">
                          ' . $addPerAction . '
                           ' . $editAction . '
                           ' . $deleteAction . '
                        </div>';
                })
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }

        return view('admin.pages.role.index');
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
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = "web";
        $save = $role->save();

        if (!$save) {
            return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
        }
        return response()->json(['status' => 'success', 'message' => 'Role created successfully'], 201);
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
        $role = Role::findOrFail($id);

        if ($role) {
            return response()->json(['status' => 'success', 'message' => 'Role fetched successfully', 'data' => $role], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        if ($role) {
            $role->name = $request->name;


            $role->save();

            return response()->json(['status' => 'success', 'message' => 'Role updated successfully'], 200);

        }
        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role) {
            $role->delete();

            return response()->json(['status' => 'success', 'message' => 'Role updated successfully'], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    public function assignPermissionsToRolePage(string $id)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($id);
        $groupedPermissions = $permissions->groupBy('group_name');

        return view('admin.pages.role.assign-permission', compact('permissions', 'role', 'groupedPermissions'));
    }

    public function assignPermissionsToRole(Request $request, string $id)
    {
//      dd(\request()->all());

        $role = Role::findOrFail($id);

        $assignPerm = $role->syncPermissions(\request()->permissions);

        if ($assignPerm) {
            return redirect()->route('admin.role.index')->with('success', 'Permission Updated !');
        }

        return redirect()->back()->with('error', 'Error Occured !');
    }
}
