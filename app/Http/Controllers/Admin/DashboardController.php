<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user can access admin dashboard
        if (!auth()->user()->canManageInventory()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Dashboard statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::whereIn('role', ['buyer', 'vip_buyer', 'commercial_buyer'])->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'low_stock_products' => Product::where('stock_quantity', '<', 10)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user->name,
                    'status' => $order->status,
                    'total_amount' => $order->total_amount,
                    'created_at' => $order->created_at->format('M d, Y'),
                ];
            });

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->where('stock_quantity', '<', 10)
            ->where('is_active', true)
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category->name,
                    'stock_quantity' => $product->stock_quantity,
                ];
            });

        // Recent inventory transactions
        $recentTransactions = InventoryTransaction::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'product_name' => $transaction->product->name,
                    'type' => $transaction->type,
                    'quantity' => $transaction->quantity,
                    'user_name' => $transaction->user->name,
                    'created_at' => $transaction->created_at->format('M d, Y'),
                ];
            });

        // Monthly sales data (placeholder for chart)
        $monthlySales = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [1200, 1900, 3000, 5000, 2300, 3400] // This would come from actual order data
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'recentTransactions' => $recentTransactions,
            'monthlySales' => $monthlySales,
            'user' => auth()->user(),
        ]);
    }
}
