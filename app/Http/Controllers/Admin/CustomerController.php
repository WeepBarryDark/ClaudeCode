<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::whereIn('role', ['buyer', 'vip_buyer', 'commercial_buyer'])
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->get();
        
        return Inertia::render('Admin/Customers', [
            'customers' => $customers,
        ]);
    }

    public function messages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        
        return Inertia::render('Admin/Messages', [
            'messages' => $messages,
        ]);
    }

    public function topProducts()
    {
        // Implementation for top products report
        return Inertia::render('Admin/TopProducts');
    }
}
