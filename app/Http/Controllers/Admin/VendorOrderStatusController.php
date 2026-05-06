<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorOrderStatus;

class VendorOrderStatusController extends Controller
{
    public function index()
    {
        $orderStatuses = VendorOrderStatus::all();

        return view('admin.pages.settings.vendor_order_status.index', compact('orderStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.settings.vendor_order_status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = new VendorOrderStatus();
        $status->status_name = $request->status_name;
        $status->status = $request->status;

        $status->save();

        return redirect()->route('admin.vendor-order-status.index')->with('success','Status created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorOrderStatus $orderStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorOrderStatus $orderStatus)
    {
        return view('admin.pages.settings.vendor-order-status.edit', compact('orderStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorOrderStatus $orderStatus)
    {
        $status = VendorOrderStatus::find($request->status_id);

        $status->status_name = $request->status_name;
        $status->status = $request->status;

        $status->update();

        return redirect()->route('admin.vendor-order-status.index')->with('success','Status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorOrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return redirect()->route('admin.vendor-order-status.index')->with('success','Status deleted successfully');
    }
}
