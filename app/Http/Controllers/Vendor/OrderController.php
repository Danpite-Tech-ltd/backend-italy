<?php

namespace App\Http\Controllers\Vendor;

use Adrianorosa\GeoLocation\GeoLocation;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Courierapi;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\VendorOrderStatus;
use App\Models\ShippingCharge;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        \Log::info($request->all());
        if (\request()->ajax()) {

            $orderStatus = OrderStatus::where('status', 1)->get();

            $status = $request->query('status', 'all'); // default 'all'

            $orders = Order::with(['orderStatus', 'orderProducts', 'customer', 'admin'])
                ->when($status != 'all', fn($q) => $q->where('order_status_id', $status))
                ->latest();

            return DataTables::eloquent($orders)
                ->addColumn('invoice_info', function ($order) {
                    return '<span class="text-center badge bg-dark mb-2"><p class="imgcbtn">' . $order->invoiceID . '</p></span>
                            <br>
                            <p>' . $order->created_at->format('d M Y') . '</p>
                            <br>
                            <p">' . $order->created_at->format('h:i A') . '</p>
                            <br>
                            <p>' . $order->created_at->diffForHumans() . '</p>';
                })
                ->addColumn('product_info', function ($order) {

                    $productInfo = '';

                    foreach ($order->orderProducts as $product) {

                        $productInfo .= '<div class="mb-2">
                                       <div class="d-flex gap-3">
                                        <a target="_blank" href="' . route('product-details', $product->product->slug) . '">
                                            <img src="' . asset($product->product->thumbnail_img) . '" width="60" height="60">
                                        </a>

                                        <br>
                                        <div>
                                        <p>' . $product->quantity . ' x ' . $product->product_name . '</p>

                                        <p style="color:blue;font-size: 18px;"> Colour: ' . $product->color . ' </p>

                                        <p style="font-size: 18px;color:red;font-weight:bold;"> Variant: ' . $product->variant . '</p>
                                        </div>
                                        </div>
                                        <br>';
                    }

                    return $productInfo;
                })
                ->addColumn('customer_info', function ($order) {
                    return '<p style="font-weight:bold;">' . $order->customer->name . '</p>
                            <br>
                            <p>' . $order->customer->email . '</p>
                            <br>
                            <p>' . $order->customer->phone . '</p>
                            <br>
                            <p>' . $order->customer->address . '</p>';
                })
                ->addColumn('status_select', function ($order) use ($orderStatus) {
                    $html = '';

                    $html .= "<select class='form-select order-status-change' data-id='{$order->id}'>";

                    foreach ($orderStatus as $status) {
                        $selected = $order->order_status_id == $status->id ? 'selected' : '';
                        $html .= '<option value="' . $status->id . '" ' . $selected . '>' . $status->status_name . '</option>';
                    }
                    $html .= '</select>';
                    return $html;


                })
                // ->addColumn('action', function ($admin) {
                //     $editAction = '';
                //     $deleteAction = '';


                //         $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('vendor.order.edit', $admin->id) . '">
                //                    <i class="fas fa-edit"></i></a>';



                //         $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                //                    data-id="' . $admin->id . '" id="deleteAdminBtn"">
                //                    <i class="fas fa-trash"></i></a>';



                //     return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                // })
                ->rawColumns(['invoice_info', 'product_info', 'customer_info', 'status_select', 'action'])
                ->rawColumns(['invoice_info', 'product_info', 'customer_info', 'status_select'])
                ->addIndexColumn()
                ->make(true);
        }
        //


        $statuses = VendorOrderStatus::where('status', 1)
            ->withCount([
                'vendororders' => function ($q) {
                    $q->where('vendor_id', Auth::guard('vendor')->user()->id);
                }
            ])
            ->get();

        return view('vendor.pages.order.index', compact(
            'statuses'
        ));
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
        //
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

    public function orderByStatus(string $id)
    {
        $count = Order::where('order_status_id', $id)->count();

        return $count;
    }

    public function orderStatusChange(Request $request)
    {
        $order_status_id = $request->order_status_id;

        $order_status = OrderStatus::find($order_status_id)->status_name;
        $order_id = $request->order_id;


        $order = Order::find($order_id);
        $order->order_status_id = $order_status_id;
        $order->save();

        //        $previousStatus = $order->getOriginal('order_status_id');

        // If delivered & has affiliate, calculate commission
        if ($order->order_status_id == 4 && $order->affiliate_id) {
            $affiliateId = $order->affiliate_id;

            // Track order products with affiliate commission
            $totalCommission = $order->orderProducts()->with('product')->get()->sum(function ($orderProduct) {
                $commissionPerUnit = $orderProduct->product->affiliate_commission ?? 0;
                return $commissionPerUnit * $orderProduct->quantity;

            });

            if ($totalCommission > 0) {
                // Update affiliate account balance
                $affiliate = User::find($affiliateId);

                if ($affiliate) {
                    $affiliate->increment('account_balance', $totalCommission);
                }
            }
        }

        return response()->json(['message' => 'Order Status Changed to ' . $order_status], 200);
    }
}
