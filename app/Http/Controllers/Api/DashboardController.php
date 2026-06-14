<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardOverview()
    {
        $user_id = Auth()->user()->id;
        // return $user_id;

        $allOrders = Order::where('user_id', $user_id)->count();
        $pendingOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 1])->count();
        $ProcessingOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 2])->count();
        $completeOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 4])->count();

        return response()->json([
            'status' => true,
            'message' => 'Dashboard Overview',
            'data' => [
                'allOrders' => $allOrders,
                'pendingOrders' => $pendingOrders,
                'ProcessingOrders' => $ProcessingOrders,
                'completeOrders' => $completeOrders
            ],
        ], 200);
    }

    public function userProfile()
    {
        $user_id = Auth()->user()->id;

        $customer = User::where('id', $user_id)->first();

        return response()->json([
            'status' => true,
            'message' => 'User Profile',
            'data' => $customer,
        ]);
    }

    public function orderStatus()
    {
        $status = OrderStatus::where('status', 1)->get();

        return response()->json([
            'status' => true,
            'message' => 'order status',
            'data' => $status,
        ]);
    }

    public function orders(Request $request)
    {
        $user_id = auth()->user()->id;

        $orders = Order::where('user_id', $user_id)
            ->select('id', 'invoiceID', 'total', 'order_date', 'order_status_id')
            ->with('orderStatus')

            // filter by status
            ->when($request->filter && $request->filter != 'all', function ($q) use ($request) {
                $q->where('order_status_id', $request->filter);
            })

            // search by invoiceID
            ->when($request->keyword, function ($q) use ($request) {
                $q->where('invoiceID', 'LIKE', '%' . $request->keyword . '%');
            })

            ->latest()
            ->paginate(24);

        return response()->json([
            'status' => true,
            'message' => 'User orders',
            'data' => $orders,
        ]);
    }

    public function orderDetails($invoiceID)
    {
        $order = Order::where('invoiceID', $invoiceID)
            ->select('id', 'invoiceID', 'subtotal', 'total', 'order_date', 'order_status_id', 'customer_note', 'vat_percentage', 'tax_percentage', 'vat', 'tax', 'delivery_charge')
            ->with('orderProducts', 'orderStatus')->get();

        return response()->json([
            'status' => true,
            'message' => 'User order',
            'data' => $order
        ]);
    }

    public function affiliateShop()
    {
        $user = auth()->user();

        $affiliateProducts = AffiliateProduct::with('product')->where('affiliate_id', Auth::id())->get();

        return response()->json([
            'status'  => true,
            'message' => 'Affiliate Shop Data Fetched Successfully',
            'data'    => [
                'user' => [
                    'name'     => $user->name,
                    'ref_code' => $user->ref_code,
                ],

                'affiliate_links' => [
                    'affiliate_url' => url('/') . "?ref=" . $user->ref_code,
                ],
                'products' => $affiliateProducts
            ]
        ]);
    }

    public function affiliateOrder($id, $status_id)
    {
        $status = 'ALL';
        if ($status_id) {
            $status = OrderStatus::where('id', $status_id)->value('status_name') ?? 'ALL';
        }

        $query = Order::with(['orderProducts', 'orderStatus'])
            ->where('affiliate_id', $id);

        if ($status !== 'ALL') {
            $query->where('order_status_id', $status_id);
        }

        $orders = $query->latest()->get();

        return response()->json([
            'status'  => true,
            'message' => "{$status} Orders Fetched Successfully",
            'data'    => [
                'current_status_filter' => $status,
                'orders'                => $orders
            ]
        ]);
    }
}
