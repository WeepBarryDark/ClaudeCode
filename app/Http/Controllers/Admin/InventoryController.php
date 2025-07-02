<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        
        return Inertia::render('Admin/Inventory', [
            'products' => $products,
        ]);
    }

    public function transactions()
    {
        $transactions = InventoryTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        
        return Inertia::render('Admin/InventoryTransactions', [
            'transactions' => $transactions,
        ]);
    }

    public function recordTransaction(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:import,sale,adjustment,return',
            'quantity' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        InventoryTransaction::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        // Update product stock
        $product = Product::find($request->product_id);
        if ($request->type === 'import' || $request->type === 'return') {
            $product->increment('stock_quantity', $request->quantity);
        } else {
            $product->decrement('stock_quantity', $request->quantity);
        }

        return redirect()->back()->with('success', 'Transaction recorded successfully.');
    }

    public function import(Request $request)
    {
        // Handle CSV import logic here
        return Inertia::render('Admin/InventoryImport');
    }

    public function areas()
    {
        // Handle area-based inventory
        return Inertia::render('Admin/InventoryAreas');
    }
}
