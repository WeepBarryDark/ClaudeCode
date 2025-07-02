<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return Inertia::render('Shop/Contact', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'category' => 'required|string|in:general,product_inquiry,sample_request,installation,warranty,complaint',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent! We\'ll get back to you soon.');
    }
}
