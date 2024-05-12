<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->carts()->where('active', true)->first();
        if(!$cart) {
            $cart = $user->carts()->create([
                'active' => true
            ])->fresh();
        }

        return new CartResource($cart);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $cart = $user->carts()->where('active', true)->first();
        if(!$cart) {
            $cart = $user->carts()->create([
                'active' => true
            ]);
            $cart->fresh();
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::where('id', $request->product_id)->first();

        if(!$cart->products()->where('products.id', $product->id)->exists()) {
            $cart->products()->attach($product->id);
            return response()->json([
                'message' => 'Product added to cart',
                'cart' => new CartResource($cart)
            ]);
        }


        return response()->json([
            'message' => 'This product is ready added to the shopping cart'
        ], 401);
    }


    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        $cart = $user->carts()->where('active', true)->first();
        if(!$cart) {
            $cart = $user->carts()->create([
                'active' => true
            ]);
            $cart->fresh();
        }

        if($cart->products()->where('products.id', $product->id)->exists()) {
            $cart->products()->detach($product->id);
            return response()->json([
                'message' => 'Product removed to cart',
                'cart' => new CartResource($cart)
            ]);
        }

        return response()->json([
            'message' => 'This product is not added to the shopping cart'
        ], 401);

    }
}
