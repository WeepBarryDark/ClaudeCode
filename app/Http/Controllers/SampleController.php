<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SampleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SampleController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $products = Product::where('is_active', true)
            ->with('category')
            ->get();

        return Inertia::render('Shop/Samples', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_address' => 'required|string|max:500',
            'selected_products' => 'required|array|min:1|max:8',
            'selected_products.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->selected_products)->get();
        
        SampleRequest::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'requested_products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                ];
            })->toArray(),
        ]);

        return redirect()->back()->with('success', 'Sample request submitted! We\'ll ship your samples within 2-3 business days.');
    }
}
