<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $user_id = Auth()->user()->id;
        $wishlists = Wishlist::where('user_id', $user_id)
            ->with([
                'product' => function ($q) {
                    $q->select('id', 'name', 'slug', 'thumbnail_img');
                },

                'product.firstVariant'
            ])
            ->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Wishlist product',
            'data' => $wishlists
        ]);
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (
            Wishlist::where('product_id', $request->product_id)
                ->where('user_id', $user_id)
                ->exists()
        ) {

            return response()->json([
                'status' => false,
                'message' => 'Product already added to wishlist.'
            ]);
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = $user_id;
        $wishlist->product_id = $request->product_id;
        $wishlist->save();

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist successfully.'
        ]);
    }

    public function delete(Request $request)
    {
        $user_id = auth()->user()->id;

        $request->validate([
            'product_id' => 'required|exists:wishlists,product_id',
        ]);

        $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $request->product_id)->first();
        $wishlist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product remove form wishlist successfully.'
        ]);

    }
}
