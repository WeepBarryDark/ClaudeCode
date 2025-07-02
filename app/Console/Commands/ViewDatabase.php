<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\ContactMessage;
use Illuminate\Console\Command;

class ViewDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:view {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View database table contents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        
        if (!$table) {
            $this->showAllTables();
            return;
        }
        
        switch($table) {
            case 'users':
                $this->showUsers();
                break;
            case 'categories':
                $this->showCategories();
                break;
            case 'products':
                $this->showProducts();
                break;
            case 'orders':
                $this->showOrders();
                break;
            case 'messages':
                $this->showMessages();
                break;
            default:
                $this->error("Unknown table: {$table}");
                $this->info("Available tables: users, categories, products, orders, messages");
        }
    }
    
    private function showAllTables()
    {
        $this->info('=== DATABASE OVERVIEW ===');
        $this->info('Users: ' . User::count());
        $this->info('Categories: ' . Category::count());
        $this->info('Products: ' . Product::count());
        $this->info('Orders: ' . Order::count());
        $this->info('Contact Messages: ' . ContactMessage::count());
        $this->info('');
        $this->info('Use: php artisan db:view [table] to view specific table');
        $this->info('Available tables: users, categories, products, orders, messages');
    }
    
    private function showUsers()
    {
        $this->info('=== USERS ===');
        $users = User::all();
        $headers = ['ID', 'Name', 'Email', 'Role', 'Created'];
        $rows = [];
        
        foreach($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->role,
                $user->created_at->format('Y-m-d')
            ];
        }
        
        $this->table($headers, $rows);
    }
    
    private function showCategories()
    {
        $this->info('=== CATEGORIES ===');
        $categories = Category::all();
        $headers = ['ID', 'Name', 'Slug', 'Active', 'Sort Order'];
        $rows = [];
        
        foreach($categories as $category) {
            $rows[] = [
                $category->id,
                $category->name,
                $category->slug,
                $category->is_active ? 'Yes' : 'No',
                $category->sort_order
            ];
        }
        
        $this->table($headers, $rows);
    }
    
    private function showProducts()
    {
        $this->info('=== PRODUCTS ===');
        $products = Product::with('category')->get();
        $headers = ['ID', 'Name', 'SKU', 'Category', 'Price', 'Stock', 'Featured'];
        $rows = [];
        
        foreach($products as $product) {
            $rows[] = [
                $product->id,
                substr($product->name, 0, 30),
                $product->sku,
                $product->category->name,
                '$' . $product->buyer_price,
                $product->stock_quantity,
                $product->is_featured ? 'Yes' : 'No'
            ];
        }
        
        $this->table($headers, $rows);
    }
    
    private function showOrders()
    {
        $this->info('=== ORDERS ===');
        $orders = Order::with('user')->get();
        
        if($orders->isEmpty()) {
            $this->info('No orders found.');
            return;
        }
        
        $headers = ['ID', 'Order #', 'Customer', 'Status', 'Total', 'Created'];
        $rows = [];
        
        foreach($orders as $order) {
            $rows[] = [
                $order->id,
                $order->order_number,
                $order->user->name,
                $order->status,
                '$' . $order->total_amount,
                $order->created_at->format('Y-m-d')
            ];
        }
        
        $this->table($headers, $rows);
    }
    
    private function showMessages()
    {
        $this->info('=== CONTACT MESSAGES ===');
        $messages = ContactMessage::all();
        
        if($messages->isEmpty()) {
            $this->info('No contact messages found.');
            return;
        }
        
        $headers = ['ID', 'Name', 'Email', 'Category', 'Status', 'Created'];
        $rows = [];
        
        foreach($messages as $message) {
            $rows[] = [
                $message->id,
                $message->name,
                $message->email,
                $message->category,
                $message->status,
                $message->created_at->format('Y-m-d')
            ];
        }
        
        $this->table($headers, $rows);
    }
}
