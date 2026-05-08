<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\BankSetup;
use App\Models\WalletVendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function create_vendor()
    {
        $countries = Country::all();
        return view('admin.pages.vendor.create_vendor', compact('countries'));
    }

    public function vendor_store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:vendors,phone',
            'email' => 'required|email|unique:vendors,email',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'country' => 'required|string',
            'city' => 'required|string',
            'post_code' => 'required|string|max:20',
            'password' => 'required|confirmed|min:6',
        ]);

        $vendor = new Vendor();
        $vendor->first_name = $request->first_name;
        $vendor->last_name = $request->last_name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->company_name = $request->company_name;
        $vendor->company_address = $request->company_address;
        $vendor->country = Country::find($request->country)->name;
        $vendor->city = City::find($request->city)->name;
        $vendor->post_code = $request->post_code;
        $vendor->password = bcrypt($request->password);
        $vendor->status = 'approved';
        $vendor->save();

        return redirect()->route('admin.approved.vendor.list')->with('success', 'Vendor registered successfully!');
    }
    public function pending_vendor_list()
    {
        if (request()->ajax()) {

            $vendors = Vendor::where('status', 'pending')->latest();

            return DataTables::eloquent($vendors)
                ->addColumn('name', function ($vendor) {
                    return $vendor->first_name . ' ' . $vendor->last_name;
                })
                ->addColumn('email', function ($vendor) {
                    return $vendor->email;
                })
                ->addColumn('status', function ($vendor) {

                    if ($vendor->status == 'approved') {

                        return '<a href="javascript:void(0)"
                                class="vendorStatus"
                                data-id="' . $vendor->id . '"
                                data-status="' . $vendor->status . '">
                                <i class="fa-solid fa-toggle-on fa-2x"></i>
                            </a>';
                    } else {

                        return '<a href="javascript:void(0)"
                                class="vendorStatus"
                                data-id="' . $vendor->id . '"
                                data-status="' . $vendor->status . '">
                                <i class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                            </a>';
                    }
                })
                ->addColumn('action', function ($vendor) {

                    $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                        data-id="' . $vendor->id . '" id="deleteVendorBtn">
                        <i class="fas fa-trash"></i></a>';

                    return '<div class="gap-3 d-flex">' . $deleteAction . '</div>';
                })
                ->rawColumns(['name', 'email', 'status', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.vendor.pending_vendor_list');
    }


    public function pending_vendor_status(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);

        $vendor->status = $vendor->status === 'approved'
            ? 'pending'
            : 'approved';

        $vendor->save();

        return response()->json([
            'message' => 'success',
            'status' => $vendor->status,
            'id' => $vendor->id,
        ]);
    }

    public function pending_vendor_delete($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response()->json([
            'message' => 'Vendor deleted successfully.',
        ]);
    }

    public function approved_vendor_list()
    {
        if (request()->ajax()) {

            $vendors = Vendor::where('status', 'approved')->latest();

            return DataTables::eloquent($vendors)
                ->addColumn('name', function ($vendor) {
                    return $vendor->first_name . ' ' . $vendor->last_name;
                })
                ->addColumn('email', function ($vendor) {
                    return $vendor->email;
                })
                ->addColumn('commission_value', function ($vendor) {
                    return $vendor->commission_value . ' %';
                })
                ->addColumn('status', function ($vendor) {

                    if ($vendor->status == 'approved') {

                        return '<a href="javascript:void(0)"
                                class="vendorStatus"
                                data-id="' . $vendor->id . '"
                                data-status="' . $vendor->status . '">
                                <i class="fa-solid fa-toggle-on fa-2x"></i>
                            </a>';
                    } else {

                        return '<a href="javascript:void(0)"
                                class="vendorStatus"
                                data-id="' . $vendor->id . '"
                                data-status="' . $vendor->status . '">
                                <i class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                            </a>';
                    }
                })
                ->addColumn('action', function ($vendor) {

                    $editAction = '<a class="btn btn-sm btn-success" href="' . url('admin/approved/vendors/edit', $vendor->id) . '">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>';

                    return '<div class="gap-3 d-flex">' . $editAction . '</div>';
                })
                ->rawColumns(['name', 'email', 'status', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pages.vendor.approved_vendor_list');
    }

    public function approved_vendor_status(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);

        $vendor->status = $vendor->status === 'approved'
            ? 'pending'
            : 'approved';

        $vendor->save();

        return response()->json([
            'message' => 'success',
            'status' => $vendor->status,
            'id' => $vendor->id,
        ]);
    }

    public function approved_vendor_edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.pages.vendor.edit_vendor', compact('vendor'));
    }

    public function approved_vendor_update(Request $request, $id)
    {
        $request->validate([
            'commission_value' => 'required'
        ]);

        $vendor = Vendor::findOrFail($id);

        $vendor->commission_value = $request->commission_value;
        $vendor->save();

        return redirect()->route('admin.approved.vendor.list')->with('success', 'Vendor commission updated successfully!');
    }

    public function withdraw()
    {
        $status = request('status', 'pending');

        $pendingCount = WalletVendor::where('status', 'pending')->count();
        $approvedCount = WalletVendor::where('status', 'approved')->count();
        $rejectedCount = WalletVendor::where('status', 'rejected')->count();


        $withdraws = WalletVendor::where('status', $status)->latest()->get();

        return view('admin.pages.vendor.withdraw', compact('withdraws', 'pendingCount', 'approvedCount', 'rejectedCount', 'status'));
    }

    public function updateWithdrawStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:wallet_vendors,id',
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string'
        ]);

        $withdraw = WalletVendor::find($request->id);

        if ($withdraw->status != 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending withdrawals can be updated'], 400);
        }

        if ($request->status == 'approved') {
            $vendor = Vendor::find($request->vendor_id);
            $vendor->decrement('balance', $request->amount);
            $vendor->save();
        }

        $withdraw->status = $request->status;
        $withdraw->admin_note = $request->admin_note;
        $withdraw->save();

        return response()->json(['success' => true, 'message' => 'Withdrawal status updated successfully']);
    }
}
