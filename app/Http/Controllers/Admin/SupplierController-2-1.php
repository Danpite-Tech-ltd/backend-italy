<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Supplier', only: ['index']),
            new Middleware('permission:Create Supplier', only: ['store', 'create']),
            new Middleware('permission:Edit Supplier', only: ['update', 'edit']),
            new Middleware('permission:Delete Supplier', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {

            $suppliers = Supplier::query();

            return DataTables::eloquent($suppliers)
                ->addColumn('status', function ($admin) {
                    //                if(Auth::guard('admin')->user()->can('Status Admin')) {
                    if ($admin->status == 1) {
                        return ' <a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                    } else {
                        return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                    }
                    //                }
                })
                // }
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Supplier')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Supplier')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pages.supplier.index');
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
        $supplier = new Supplier();
        $supplier->vendor_id = $request->vendor_id;
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->company_name = $request->company_name;
        $supplier->total_amount = $request->total_amount;
        $supplier->paid_amount = $request->paid_amount;
        $supplier->due_amount = $request->due_amount;
//        $supplier->partial_amount = $request->partial_amount;
        $supplier->save();

        return response()->json(['status' => 'success', 'message' => 'Supplier created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return response()->json(['status' => 'success', 'data' => $supplier], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {

        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->company_name = $request->company_name;
        $supplier->save();

        return response()->json(['status' => 'success', 'message' => 'Supplier Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(['status' => 'success', 'message' => 'Supplier deleted successfully'], 200);
    }

    public function changeSupplierStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Supplier::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }
}
