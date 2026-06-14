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
    // public function dashboardOverview()
    // {
    //     $user_id = Auth()->user()->id;
    //     // return $user_id;

    //     $allOrders = Order::where('user_id', $user_id)->count();
    //     $pendingOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 1])->count();
    //     $ProcessingOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 2])->count();
    //     $completeOrders = Order::where(['user_id' => $user_id, 'order_status_id' => 4])->count();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Dashboard Overview',
    //         'data' => [
    //             'allOrders' => $allOrders,
    //             'pendingOrders' => $pendingOrders,
    //             'ProcessingOrders' => $ProcessingOrders,
    //             'completeOrders' => $completeOrders
    //         ],
    //     ], 200);
    // }

    public function dashboardOverview()
    {
        $user = auth()->user();
        $userId = $user->id;
        $today = Carbon::today();

        $responseData = [];

        if ($user->hasRole('user')) {
            $responseData = [
                'role'               => 'user',
                'totalOrders'        => Order::where('user_id', $userId)->count(),
                'pendingOrders'      => Order::where('user_id', $userId)->where('order_status_id', 1)->count(),
                'wish'               => Wishlist::where('user_id', $userId)->count(),
                'todayTotalOrders'   => Order::where('user_id', $userId)->whereDate('created_at', $today)->count(),
                'todayPendingOrders' => Order::where('user_id', $userId)->where('order_status_id', 1)->whereDate('created_at', $today)->count(),
                'todayWish'          => Wishlist::where('user_id', $userId)->whereDate('created_at', $today)->count(),
            ];
        } else if ($user->hasRole('affiliate')) {
            $responseData = [
                'role'                  => 'affiliate',
                'totalOrders'           => Order::where('user_id', $userId)->count(),
                'totalPendingOrders'    => Order::where('affiliate_id', $userId)->where('order_status_id', 1)->count(),
                'totalShippedOrders'    => Order::where('affiliate_id', $userId)->where('order_status_id', 3)->count(),
                'totalDeliveredOrders'  => Order::where('affiliate_id', $userId)->where('order_status_id', 4)->count(),
                'totalCancelledOrders'  => Order::where('affiliate_id', $userId)->where('order_status_id', 5)->count(),
                'totalReturnOrders'     => Order::where('affiliate_id', $userId)->where('order_status_id', 6)->count(),
                'totalSale'             => Order::where('affiliate_id', $userId)->sum('subtotal'),
                'myShop'                => AffiliateProduct::where('affiliate_id', $userId)->count(),
                'accountBalance'        => $user->account_balance ?? 0,
                'withdrawalBalance'     => $user->withdrawal_balance ?? 0,
                
                // Today's statistics data block
                'todayTotalOrders'      => Order::where('user_id', $userId)->whereDate('created_at', $today)->count(),
                'todayPendingOrders'    => Order::where('user_id', $userId)->where('order_status_id', 1)->whereDate('created_at', $today)->count(),
                'todayShippedOrders'    => Order::where('user_id', $userId)->where('order_status_id', 3)->whereDate('created_at', $today)->count(),
                'todayDeliveredOrders'  => Order::where('user_id', $userId)->where('order_status_id', 4)->whereDate('created_at', $today)->count(),
                'todayCancelledOrders'  => Order::where('user_id', $userId)->where('order_status_id', 5)->whereDate('created_at', $today)->count(),
                'todayReturnOrders'     => Order::where('user_id', $userId)->where('order_status_id', 6)->whereDate('created_at', $today)->count(),
            ];
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized Role Access'
            ], 403);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Dashboard Overview Data Fetched',
            'data'    => $responseData
        ]);
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

    public function withdrawHistory($id)
    {
        $withdrawals = AffiliateWithdraw::where('affiliate_id', $id)
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Withdraw history fetched successfully',
            'data'    => $withdrawals
        ]);
    }

    public function withdrawalRequestPage()
    {
        $affiliate = User::where('id', auth()->user()->id)->first();

        return response()->json([
            'status'  => true,
            'message' => 'Withdrawal request page data fetched',
            'data'    => [
                'account_balance' => $affiliate->account_balance ?? 0,
            ]
        ]);
    }

    public function withdrawalRequest(Request $request)
    {
        $request->validate([
            'amount'          => 'required|numeric|min:1',
            'payment_method'  => 'required|string',
            'payment_details' => 'nullable|string',
        ]);

        $affiliate = User::where('id', auth()->user()->id)->first();

        if (!$affiliate) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($request->amount > $affiliate->account_balance) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have enough balance to withdraw'
            ], 422); 
        }

        $withdraw = new AffiliateWithdraw();
        $withdraw->affiliate_id   = $affiliate->id;
        $withdraw->invoiceID      = uniqid();
        $withdraw->amount         = $request->amount;
        $withdraw->payment_method = $request->payment_method;
        $withdraw->payment_details = $request->payment_details;
        $withdraw->save();

        $affiliate->account_balance    = $affiliate->account_balance - $request->amount;
        $affiliate->withdrawal_balance = $affiliate->withdrawal_balance + $request->amount;
        $affiliate->save();

        return response()->json([
            'status'  => true,
            'message' => 'Withdrawal Request Sent Successfully',
            'data'    => [
                'withdraw_id' => $withdraw->id,
                'invoice_id'  => $withdraw->invoiceID,
                'current_balance' => $affiliate->account_balance
            ]
        ], 200);
    }
}
