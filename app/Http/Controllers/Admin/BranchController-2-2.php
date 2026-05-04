<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (\request()->ajax()) {
            $branches = Branch::query();
        return DataTables::eloquent($branches)
            // ->addColumn('status', function ($admin) {
            //         if ($admin->status == 1) {
            //             return ' <a class="status" id="adminStatus" href="javascript:void(0)"
            //                                    data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
            //                                             class="fa-solid fa-toggle-on fa-2x"></i>
            //                                 </a>';
            //         } else {
            //             return '<a class="status" id="adminStatus" href="javascript:void(0)"
            //                                    data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
            //                                             class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
            //                                 </a>';
            //         }

            //     })
                // ->addColumn('action', function ($admin) {
                //     $editAction = '';
                //     $deleteAction = '';

                //     if (Auth::user()->can('Edit Category')) {
                //         $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                //                    <i class="fas fa-edit"></i></a>';
                //     }

                //     if (Auth::user()->can('Delete Category')) {
                //         $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                //                    data-id="' . $admin->id . '" id="deleteAdminBtn"">
                //                    <i class="fas fa-trash"></i></a>';
                //     }




                //     return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                // })

                // ->rawColumns(['action',  'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.branch.index');

         }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:branches',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:branches',
            'address' => 'nullable|string'
        ]);

        Branch::create($request->all());

        return redirect()->route('admin.branch.index')->with('success', 'Branch created successfully.');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
