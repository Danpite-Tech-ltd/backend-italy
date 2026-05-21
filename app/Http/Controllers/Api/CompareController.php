<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compare;
use Illuminate\Http\Request;

class CompareController extends Controller
{

    public function index(Request $request)
    {
        $user_id = auth()->user()->id;

        $compares = Compare::where('user_id', $user_id)->with('products', 'products.firstVariant')->get();

        return response()->json([
            'status' => true,
            'message' => "Compare product data",
            'data' => $compares
        ]);
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        // Maximum 4 compare products
        $compareCount = Compare::where('user_id', $user_id)->count();

        if ($compareCount >= 4) {
            return response()->json([
                'status' => false,
                'message' => "You can add maximum 4 products for compare."
            ]);
        }

        // Already exists check
        if (
            Compare::where('user_id', $user_id)
                ->where('product_id', $request->product_id)
                ->exists()
        ) {
            return response()->json([
                'status' => false,
                'message' => "Already added on compare"
            ]);
        }

        $compare = new Compare();
        $compare->user_id = $user_id;
        $compare->product_id = $request->product_id;
        $compare->save();

        return response()->json([
            'status' => true,
            'message' => "Compare product data created successfully.",
            'data' => $compare
        ]);
    }

    public function delete(Request $request)
    {
        
    }
}
