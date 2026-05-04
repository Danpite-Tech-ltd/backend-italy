<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ShippingChargeController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:Shipping Charge', only: ['index','store','update','destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingCharges = ShippingCharge::all();

        return view('admin.pages.settings.shipping-charge.index', compact('shippingCharges'));
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
        $shippingCharge = new ShippingCharge();

        $shippingCharge->area_name = $request->area_name;
        $shippingCharge->delivery_charge = $request->delivery_charge;
        $shippingCharge->status = $request->status;

        $shippingCharge->save();

        return redirect()->back()->with('success', 'Shipping Charge Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCharge $shippingCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCharge $shippingCharge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCharge $shippingCharge)
    {
        $shippingCharge->area_name = $request->area_name;
        $shippingCharge->delivery_charge = $request->delivery_charge;
        $shippingCharge->status = $request->status;

        $shippingCharge->save();

        return redirect()->back()->with('success', 'Shipping Charge Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCharge $shippingCharge)
    {
        $shippingCharge->delete();

        return redirect()->back()->with('success', 'Shipping Charge Deleted Successfully');
    }
}
