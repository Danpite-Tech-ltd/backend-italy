<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateWithdraw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AffiliateController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Affiliate', only: ['index']),
            new Middleware('permission:Create Affiliate', only: ['store', 'create']),
            new Middleware('permission:Edit Affiliate', only: ['update', 'edit']),
            new Middleware('permission:Delete Affiliate', only: ['destroy']),
            new Middleware('permission:Show Affiliate', only: ['show']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {

            $affiliates = User::role('affiliate');

            return DataTables::eloquent($affiliates)
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

                    $viewAction = '';
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Show Affiliate')) {
                        $viewAction = '<a class="btn btn-sm btn-secondary" href="' . route('admin.affiliate.show', $admin->id) . '"><i class="fas fa-eye"></i></a>';
                    }

                    if (Auth::user()->can('Edit Affiliate')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Affiliate')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="gap-3 d-flex"> ' . $viewAction . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.affiliate.index');
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|unique:users',
            'address' => 'nullable|string',
            'account_balance' => 'numeric',
            'withdrawal_balance' => 'numeric',
            'password' => 'required|string',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $affiliate = new User();
        $affiliate->name = $request->name;
        $affiliate->slug = Str::slug($request->name) . uniqid();
        $affiliate->email = $request->email;
        $affiliate->phone = $request->phone;
        $affiliate->address = $request->address;
        $affiliate->password = Hash::make($request->password);

        $affiliate->account_balance = $request->account_balance;
        $affiliate->withdrawal_balance = $request->withdrawal_balance;


        $affiliate->syncRoles('affiliate');

        if ($request->hasFile('profile_image')) {

            $file = $request->file('profile_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/upload/admin/'), $filename);
            $affiliate->profile_image = 'public/admin/upload/admin/' . $filename;
        }

        $save = $affiliate->save();

        if ($save) {
            return response()->json(['status' => 'success', 'message' => 'Affiliate created successfully'], 201);
        }

        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.affiliate.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $affiliate = User::findOrFail($id);


        if ($affiliate) {
            return response()->json(['status' => 'success', 'message' => 'Admin fetched successfully', 'data' => $affiliate], 200);
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
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'account_balance' => 'numeric',
            'withdrawal_balance' => 'numeric',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $affiliate = User::findOrFail($id);

        if ($affiliate) {

            $affiliate->name = $request->name;
            $affiliate->email = $request->email;

            $affiliate->phone = $request->phone;
            $affiliate->address = $request->address;

            $affiliate->account_balance = $request->account_balance;
            $affiliate->withdrawal_balance = $request->withdrawal_balance;

            $affiliate->syncRoles('affiliate');

            if ($request->hasFile('profile_image')) {
                if ($affiliate->profile_image && file_exists($affiliate->profile_image)) {
                    unlink($affiliate->profile_image);
                }
                $file = $request->file('profile_image');
                $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('admin/upload/admin/'), $filename);
                $affiliate->profile_image = 'public/admin/upload/admin/' . $filename;
            }

            $save = $affiliate->save();

            if ($save) {
                return response()->json(['status' => 'success', 'message' => 'Admin Updated successfully'], 200);
            }
        }


        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $affiliate = User::findOrFail($id);

        if ($affiliate) {
            $affiliate->delete();

            return response()->json(['status' => 'success', 'message' => 'Admin Deleted successfully'], 200);
        }
        return response()->json(['status' => 'failed', 'message' => 'Something went wrong'], 500);
    }

    public function changeAffiliateStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = User::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }












    public function affiliateWithdrawList()
    {
        return view('admin.pages.affiliate.pending-withdraw-list');
    }
    public function affiliateWithdrawListstore()
    {
        if (\request()->ajax()) {

            $affiliateWithdraw = AffiliateWithdraw::latest()->where('status',0)->get();

            return Datatables::of($affiliateWithdraw)
            ->addColumn('name', function ($affiliate) {
                return User::find($affiliate->affiliate_id)->name;
            })
            ->addColumn('email', function ($affiliate) {
                return User::find($affiliate->affiliate_id)->email;
            })
            ->addColumn('request_balance', function ($affiliate) {
                return $affiliate->amount;
            })
            ->addColumn('status', function ($affiliate) {
                if ($affiliate->status == 1) {
                    return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                            data-id="' . $affiliate->id . '" data-status="' . $affiliate->status . '"> <i
                                                    class="fa-solid fa-toggle-on fa-2x"></i>
                                        </a>';
                } else {
                    return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                            data-id="' . $affiliate->id . '" data-status="' . $affiliate->status . '"> <i
                                                    class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                        </a>';
                }
            })
            ->addColumn('action', function ($affiliate) {

                $viewAction = '';
                $editAction = '';
                $deleteAction = '';

                if (Auth::user()->can('Show Affiliate')) {
                    $viewAction = '<a class="btn btn-sm btn-secondary" href="' . route('admin.affiliate-withdraw.show', $affiliate->id) . '"><i class="fas fa-eye"></i></a>';
                }

                return '<div class="gap-3 d-flex"> ' . $viewAction . $editAction . $deleteAction . '</div>';
            })
            ->rawColumns(['name','email','request_balance','status','action'])
            ->make(true);
        }

    }
    public function affiliateWithdrawApproveList()
    {
        return view('admin.pages.affiliate.approved-withdraw-list');
    }
    public function affiliateApprovedWithdrawListstore()
    {
        if (\request()->ajax()) {

            $affiliateWithdraw = AffiliateWithdraw::latest()->where('status',1)->get();

            return Datatables::of($affiliateWithdraw)
            ->addColumn('name', function ($affiliate) {
                return User::find($affiliate->affiliate_id)->name;
            })
            ->addColumn('email', function ($affiliate) {
                return User::find($affiliate->affiliate_id)->email;
            })
            ->addColumn('request_balance', function ($affiliate) {
                return $affiliate->amount;
            })
            ->addColumn('status', function ($affiliate) {
                if ($affiliate->status == 1) {
                    return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                            data-id="' . $affiliate->id . '" data-status="' . $affiliate->status . '"> <i
                                                    class="fa-solid fa-toggle-on fa-2x"></i>
                                        </a>';
                } else {
                    return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                            data-id="' . $affiliate->id . '" data-status="' . $affiliate->status . '"> <i
                                                    class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                        </a>';
                }
            })
            ->addColumn('action', function ($affiliate) {

                $viewAction = '';
                $editAction = '';
                $deleteAction = '';

                if (Auth::user()->can('Show Affiliate')) {
                    $viewAction = '<a class="btn btn-sm btn-secondary" href="' . route('admin.affiliate-withdraw.show', $affiliate->id) . '"><i class="fas fa-eye"></i></a>';
                }

                return '<div class="gap-3 d-flex"> ' . $viewAction . $editAction . $deleteAction . '</div>';
            })
            ->rawColumns(['name','email','request_balance','status','action'])
            ->make(true);
        }

    }


    public function changeAffiliateWithdrawStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = AffiliateWithdraw::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }

    public function affiliateWithdrawShow($id)
    {
        $affiliatewithdraw = AffiliateWithdraw::findOrFail($id);
        $user = User::find($affiliatewithdraw->affiliate_id);
        return view('admin.pages.affiliate.withdraw-show', compact('user', 'affiliatewithdraw'));
    }
}
