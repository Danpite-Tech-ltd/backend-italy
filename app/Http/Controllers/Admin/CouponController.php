<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Coupon', only: ['index']),
            new Middleware('permission:Create Coupon', only: ['store', 'create']),
            new Middleware('permission:Edit Coupon', only: ['update', 'edit']),
            new Middleware('permission:Delete Coupon', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $coupons = Coupon::query();

            return DataTables::eloquent($coupons)
                ->addColumn('status', function ($admin) {
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
                })
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Coupon')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Coupon')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.coupon.index');
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
            'name' => 'required',
            'code' => 'required|string',
            'type' => 'required|string',
            'discount' => 'required|numeric',
            'expire_date' => 'required|date',
            'active_date' => 'required|date|before:expire_date'
        ],
            [
                'active_date.before' => 'The active date must be before the expiry date.',
            ]);

        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->expire_date = $request->expire_date;
        $coupon->active_date = $request->active_date;
        $coupon->status = $request->status;

        $coupon->save();

        return response()->json(['status' => 'success', 'message' => 'Coupon created successfully'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return response()->json(['status' => 'success', 'message' => 'Coupon fetched successfully', 'data' => $coupon], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate(
            [
                'name' => 'required',
                'code' => 'required|string',
                'type' => 'required|string',
                'discount' => 'required|numeric',
                'expire_date' => 'required|date',
                'active_date' => 'required|date|before:expire_date'
            ],
            [
                'active_date.before' => 'The active date must be before the expiry date.',
            ]);

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->expire_date = $request->expire_date;
        $coupon->active_date = $request->active_date;
        $coupon->status = $request->status;

        $coupon->save();

        return response()->json(['status' => 'success', 'message' => 'Coupon Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json(['status' => 'success', 'message' => 'Coupon deleted successfully'], 200);
    }

    public function changeCouponStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Coupon::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }
}
