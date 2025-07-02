<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                $price = $product->getDisplayPrice(auth()->user()?->role ?? 'buyer');
                $itemTotal = $price * $item['quantity'];
                $total += $itemTotal;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $itemTotal,
                ];
            }
        }

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return Inertia::render('Shop/Cart', [
            'categories' => $categories,
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        $productId = $request->product_id;
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $request->quantity,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);
        $productId = $request->product_id;

        if ($request->quantity === 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $request->quantity;
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function checkout(Request $request)
    {
        // For now, just clear the cart and show success
        // In a real implementation, this would process payment
        session()->forget('cart');
        
        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
