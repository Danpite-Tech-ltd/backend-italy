<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{


    public function index()
    {

        $vendor = Auth::guard('vendor')->user();

        if (!$vendor) {
            return redirect()->route('vendor.login');
        }


        if (\request()->ajax()) {

            $suppliers = Supplier::with([
                'vendor' => function ($query) {
                    $query->select('id', 'company_name');
                },
            ])
                // ->where('status', 1)
                ->where('vendor_id', $vendor->id);

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
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';


                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';


                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';


                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })


                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('vendor.pages.supplier.index');
    }

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
}
