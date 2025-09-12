<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return view('cart.index', compact('products', 'cartItems', 'total'));
    }

    public function add(Product $product)
    {
        $cartItem = Cart::where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity'   => 1,
                'price'      => $product->price,
            ]);
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.index')->with('success');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        Cart::destroy($id);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.index')->with('success');
    }
    public function clearAll()
    {
        Cart::truncate();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.index')->with('success');
    }
}
