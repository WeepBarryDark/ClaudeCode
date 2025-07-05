<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Shop/Home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }

    public function products(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by price range
        if ($request->min_price) {
            $query->where('buyer_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('buyer_price', '<=', $request->max_price);
        }

        // Filter by colors
        if ($request->colors) {
            $colors = explode(',', $request->colors);
            $query->where(function ($q) use ($colors) {
                foreach ($colors as $color) {
                    $q->orWhereJsonContains('colors', $color);
                }
            });
        }

        // Filter by sizes
        if ($request->sizes) {
            $sizes = explode(',', $request->sizes);
            $query->where(function ($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhereJsonContains('sizes', $size);
                }
            });
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'name';
        $sortOrder = $request->sort_order ?? 'asc';
        
        if ($sortBy === 'price_low') {
            $query->orderBy('buyer_price', 'asc');
        } elseif ($sortBy === 'price_high') {
            $query->orderBy('buyer_price', 'desc');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Shop/Products', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['category', 'min_price', 'max_price', 'colors', 'sizes', 'sort_by']),
        ]);
    }

    public function categoryProducts($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with('category')
            ->paginate(12);

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Shop/CategoryProducts', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return Inertia::render('Shop/ProductDetail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function about()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return Inertia::render('Shop/About', [
            'categories' => $categories,
        ]);
    }
}
