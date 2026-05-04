<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $discounts = Discount::query();

            return DataTables::eloquent($discounts)
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


                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';



                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';


                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.discount.index');
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
            ]
        );

        $discount = new Discount();
        $discount->name = $request->name;
        $discount->code = $request->code;
        $discount->type = $request->type;
        $discount->discount = $request->discount;
        $discount->expire_date = $request->expire_date;
        $discount->active_date = $request->active_date;
        $discount->status = $request->status;

        $discount->save();

        return response()->json(['status' => 'success', 'message' => 'Discount created successfully'], 201);
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
     public function edit(Discount $discount)
    {
       return response()->json(['status' => 'success', 'message' => 'Discount fetched successfully', 'data' => $discount], 200);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Discount $discount)
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

        $discount->name = $request->name;
        $discount->code = $request->code;
        $discount->type = $request->type;
        $discount->discount = $request->discount;
        $discount->expire_date = $request->expire_date;
        $discount->active_date = $request->active_date;
        $discount->status = $request->status;

        $discount->save();

        return response()->json(['status' => 'success', 'message' => 'Discount Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json(['status' => 'success', 'message' => 'Discount deleted successfully'], 200);
    }

    public function changeDiscountStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Discount::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }
}
