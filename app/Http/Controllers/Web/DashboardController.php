<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\AffiliateWithdraw;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalOrders = $pendingOrders = $wish = $todayTotalOrders = $todayPendingOrders = $todayWish = 0;
        $totalSale = $myShop = $accountBalance = $withdrawalBalance = 0;
        $totalOrders = $totalPendingOrders = $totalShippedOrders = $totalDeliveredOrders = $totalCancelledOrders = $totalReturnOrders = 0;

        $todayTotalSale = $todayMyShop = $todayAccountBalance = $todayWithdrawalBalance = 0;
        $todayTotalOrders = $todayShippedOrders = $todayDeliveredOrders = $todayCancelledOrders = $todayReturnOrders = 0;

        if (auth()->user()->hasRole('user')) {
            $totalOrders = Order:: where('user_id', auth()->user()->id)->count();

            $pendingOrders = Order:: where('user_id', auth()->user()->id)->where('order_status_id', 1)->count();

            $wish = Wishlist::where('user_id', auth()->user()->id)->count();

            $todayTotalOrders = Order::where('user_id', auth()->id())
                ->whereDate('created_at', Carbon::today())
                ->count();

            $todayPendingOrders = Order::where('user_id', auth()->id())
                ->where('order_status_id', 1)
                ->whereDate('created_at', Carbon::today())
                ->count();

            $todayWish = Wishlist::where('user_id', auth()->id())
                ->whereDate('created_at', Carbon::today())
                ->count();
        } else if (auth()->user()->hasRole('affiliate')) {
            $affiliate_id = auth()->user()->id;

            $totalOrders = Order::where('user_id', $affiliate_id)->count();
            $totalPendingOrders = Order::where('affiliate_id', $affiliate_id)->where('order_status_id', 1)->count();
            $totalShippedOrders = Order::where('affiliate_id', $affiliate_id)->where('order_status_id', 3)->count();
            $totalDeliveredOrders = Order::where('affiliate_id', $affiliate_id)->where('order_status_id', 4)->count();
            $totalCancelledOrders = Order::where('affiliate_id', $affiliate_id)->where('order_status_id', 5)->count();
            $totalReturnOrders = Order::where('affiliate_id', $affiliate_id)->where('order_status_id', 6)->count();

            $totalSale = Order::where('affiliate_id', $affiliate_id)->sum('subtotal');
            $myShop = AffiliateProduct::where('affiliate_id', $affiliate_id)->count();

            $accountBalance = User::where('id', $affiliate_id)->value('account_balance');
            $withdrawalBalance = User::where('id', $affiliate_id)->value('withdrawal_balance');

            //today
            $todayTotalOrders = Order::where('user_id', $affiliate_id)
                ->whereDate('created_at', Carbon::today())
                ->count();
            $todayPendingOrders = Order::where('user_id', $affiliate_id)
                ->where('order_status_id', 1)
                ->whereDate('created_at', Carbon::today())
                ->count();
            $todayShippedOrders = Order::where('user_id', $affiliate_id)
                ->where('order_status_id', 3)
                ->whereDate('created_at', Carbon::today())
                ->count();
            $todayDeliveredOrders = Order::where('user_id', $affiliate_id)
                ->where('order_status_id', 4)
                ->whereDate('created_at', Carbon::today())
                ->count();
            $todayCancelledOrders = Order::where('user_id', $affiliate_id)
                ->where('order_status_id', 5)
                ->whereDate('created_at', Carbon::today())
                ->count();
            $todayReturnOrders = Order::where('user_id', $affiliate_id)
                ->where('order_status_id', 6)
                ->whereDate('created_at', Carbon::today())
                ->count();

        }

        // Check the user's role to return the appropriate view data
        if (auth()->user()->hasRole('user')) {
            return view('frontend.content.dashboard.index', compact(
                'totalOrders', 'pendingOrders', 'wish', 'todayTotalOrders', 'todayPendingOrders', 'todayWish'
            ));
        } elseif (auth()->user()->hasRole('affiliate')) {
            return view('frontend.content.dashboard.index', compact(
                'totalOrders', 'totalPendingOrders', 'totalShippedOrders', 'totalDeliveredOrders',
                'totalCancelledOrders', 'totalReturnOrders', 'totalSale', 'myShop',
                'accountBalance', 'withdrawalBalance', 'todayTotalOrders', 'todayPendingOrders',
                'todayShippedOrders', 'todayDeliveredOrders', 'todayCancelledOrders', 'todayReturnOrders'
            ));
        }

        // Fallback in case the user has no role (optional)
        return redirect('/');
    }

    public function affiliateOrder(string $id, $status_id = null)
    {
//        dd($status_id);
        $status = OrderStatus::where('id', $status_id)->first()->status_name ?? 'ALL';

        $query = Order::with('orderProducts')
            ->where('affiliate_id', $id);

        if ($status != 'ALL') {
            $query->where('order_status_id', $status_id);
        }

        $orders = $query->get();


        return view('frontend.content.dashboard.affiliate-order', compact('orders', 'status'));
    }

    public function withdrawHistory(string $id)
    {
//        dd($id);
        $withdrawals = AffiliateWithdraw::where('affiliate_id', $id)->with('user')->get();


        return view('frontend.content.dashboard.withdraw-history', compact('withdrawals'));
    }


    public function userOrders()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return view('frontend.content.dashboard.orders', compact('orders'));
    }

    public function userWishlist()
    {
        if (Auth::id()) {
            $user = User::where('id', Auth::user()->id)->first();
            if ($user && $user->hasRole('user')) {
                $wishlists = Wishlist::where('user_id', $user->id)->get();
            } else {
                $wishlists = Wishlist::where('ip', \Request::ip())->get();
            }
        } else {
            $wishlists = Wishlist::where('ip', \Request::ip())->get();
        }

        return view('frontend.content.dashboard.wishlist', compact('wishlists'));
    }

    public function userProfile()
    {
        return view('frontend.content.dashboard.profile');
    }

    public function userSettings()
    {
        $sessions = DB::table('sessions')->where('user_id', auth()->id())->get();

        $devices = $sessions->map(function ($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);

            return [
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'device' => $agent->device(),
                'ip' => $session->ip_address,
                'is_current' => $session->id === session()->getId(),
                'last_seen' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        return view('frontend.content.dashboard.settings', compact('devices'));
    }

    public function userProfileUpdate(Request $request)
    {

    //    dd($request->all());
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->file('profile_image')) {
            $image = $request->file('profile_image');

            if (!is_null($user->profile_image) && file_exists($user->profile_image)) {
                unlink($user->profile_image);
            }

            $imageName          = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath          = 'public/admin/upload/admin/';
            $image->move($imagePath, $imageName);

            $user->profile_image   = $imagePath . $imageName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }


    public function userSettingsUpdate(Request $request)
    {
//        dd($request->all());

        $user = Auth::user();

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // exclude current user
            'password' => 'nullable|min:6|confirmed',
        ]);

        //  Update name & email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        //  Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();


//        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();


        return redirect()->route('home')->with('success', 'Account Deleted Successfully');
    }

    public function affiliateShop()
    {
        $affiliateProducts = AffiliateProduct::with('product')->where('affiliate_id', Auth::id())->get();

        return view('frontend.content.dashboard.shop', compact('affiliateProducts'));
    }


    public function withdrawalRequestPage()
    {
        $affiliate = User::where('id', auth()->user()->id)->first();

        return view('frontend.content.dashboard.withdrawal-request', compact('affiliate'));
    }


    public function withdrawalRequest(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_details' => 'nullable|string',
        ]);

        $affiliate = User::where('id', auth()->user()->id)->first();


        if ($request->amount > $request->account_balance) {

            return redirect()->back()->with('error', 'You do not have enough balance to withdraw');
        } else {
            $withdraw = new AffiliateWithdraw();

            $withdraw->affiliate_id = auth()->user()->id;
            $withdraw->invoiceID = uniqid();
            $withdraw->amount = $request->amount;
            $withdraw->payment_method = $request->payment_method;
            $withdraw->payment_details = $request->payment_details;
            $withdraw->save();

            $affiliate->account_balance = $request->account_balance - $request->amount;
            $affiliate->withdrawal_balance = $request->withdrawal_balance + $request->amount;
            $affiliate->save();

            return redirect()->route('affiliate-withdrawal-history', $withdraw->id)->with('success', 'Withdrawal Request Sent Successfully');
        }
    }

    public function posOrder()
    {
        $orderStatus = OrderStatus::where('status', 1)->get();

        return view('frontend.content.dashboard.pos-order', compact('orderStatus'));
    }


    public function productsForPurchase(Request $request)
    {
        if (isset($request['q'])) {
            $type0 = DB::table('productvariants')
                ->select(
                    'productvariants.*',
                    'products.name',
                    'products.SKU',
                    'products.thumbnail_img',
                    'productcolors.color_name as color_name',

                )
                ->join('products', 'products.id', '=', 'productvariants.product_id')
                ->leftJoin('productcolors', 'productcolors.id', '=', 'productvariants.productcolor_id')
                ->where('name', 'like', '%' . $request['q'] . '%')->get();
        } else {
            $type0 = DB::table('productvariants')
                ->select(
                    'productvariants.*',
                    'products.name',
                    'products.SKU',
                    'products.thumbnail_img',
                    'productcolors.color_name as color_name',

                )
                ->join('products', 'products.id', '=', 'productvariants.product_id')
                ->leftJoin('productcolors', 'productcolors.id', '=', 'productvariants.productcolor_id')
                ->where('name', 'like', '%' . $request['q'] . '%')->get();
        }

        $products = $type0;

        foreach ($products as $item) {

            if (App::environment('local')) {
                $item->thumbnail_img = url($item->thumbnail_img);
            } else {
                $item->thumbnail_img = url($item->thumbnail_img);
            }
            $product[] = array(
                "id" => $item->product_id,
                "size_id" => $item->id,
                "text" => $item->name,
                "color" => $item->color_name,
                "size" => $item->variant_name,
                "image" => $item->thumbnail_img,
                "productCode" => $item->SKU,
                "productPrice" => intval($item->sale_price)
            );
        }

        $data['data'] = $product;
        return $data;
    }


    public function posOrderStore(Request $request)
    {
//        dd($request->all());

        $products = $request['data']['products'];

        $total = $request['data']['total'] - $request['data']['discountCharge'] ?? 0;


        DB::beginTransaction();

        try {
//          Create Customer
            $customer = new Customer();
            $customer->name = $request['data']['customerName'];
            $customer->phone = $request['data']['customerPhone'];
            $customer->address = $request['data']['customerAddress'];
            $customer->save();


//          Create Order
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->invoiceID = uniqid();
            $order->payment_method = $request['data']['payment_type'];
            $order->customer_note = $request['data']['customerNote'];
            $order->subtotal = $total - $request['data']['deliveryCharge'];
            $order->total = $total;
            $order->affiliate_id = auth()->user()->id;

            $order->delivery_charge = $request['data']['deliveryCharge'];
            $order->discount_charge = $request['data']['discountCharge'];
            $order->order_date = today();
            $order->order_status_id = $request['data']['status'];
            $order->save();

//          Create Order Products
            foreach ($products as $product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['productID'];
                $orderProduct->productvariant_id = $product['sizeID'];
                $orderProduct->product_name = $product['productName'];
                $orderProduct->product_SKU = $product['productCode'];
                $orderProduct->product_price = $product['productPrice'];
                $orderProduct->quantity = $product['productQuantity'];
                $orderProduct->color = $product['productColor'];
                $orderProduct->variant = $product['productSize'];
                $orderProduct->save();
            }

            DB::commit();


            $response['status'] = 'success';
            $response['message'] = 'Successfully Add Order';

            return json_encode($response);

        } catch (Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }
    }
}
