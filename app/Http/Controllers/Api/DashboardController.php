<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardOverview(){
        $user_id = Auth()->user()->id;
        // return $user_id;
        
        $allOrders = Order::where('user_id', $user_id)->count();
        $pendingOrders = Order::where(['user_id' => $user_id, 'order_status_id'=> 1])->count();
        $ProcessingOrders = Order::where(['user_id' => $user_id, 'order_status_id'=> 2])->count();
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
}
