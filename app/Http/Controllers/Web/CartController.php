<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    // Add product to cart or increase quantity if already exists
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color_id' => 'nullable|integer',
            'variant_id' => 'nullable|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        // Check if product (with optional color/variant) already in cart
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cart) {
            // Increase quantity
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            // Create new cart record
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Update quantity of a cart item
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        $cart = Cart::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Cart item quantity updated successfully'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    // Remove a cart item
    public function destroy(Cart $cart)
    {
        $userId = Auth::id();

//      $cart = Cart::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }



}
