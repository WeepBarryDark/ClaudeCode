<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            [
                'category' => 'Hardwood Flooring',
                'name' => 'Premium Oak Hardwood',
                'sku' => 'HW-OAK-001',
                'description' => 'Beautiful solid oak hardwood flooring with rich grain patterns',
                'buyer_price' => 8.50,
                'vip_buyer_price' => 7.65,
                'commercial_buyer_price' => 6.80,
                'colors' => ['Natural', 'Honey', 'Espresso'],
                'sizes' => ['3\"', '5\"', '7\"'],
                'stock_quantity' => 1000,
                'is_featured' => true
            ],
            [
                'category' => 'Luxury Vinyl Plank',
                'name' => 'Waterproof LVP Collection',
                'sku' => 'LVP-WP-001',
                'description' => 'Waterproof luxury vinyl plank with realistic wood texture',
                'buyer_price' => 4.25,
                'vip_buyer_price' => 3.83,
                'commercial_buyer_price' => 3.40,
                'discount_price' => 3.99,
                'colors' => ['Oak', 'Maple', 'Walnut', 'Cherry'],
                'sizes' => ['6\"', '7\"', '9\"'],
                'stock_quantity' => 2000,
                'is_featured' => true
            ],
            [
                'category' => 'Laminate Flooring',
                'name' => 'Classic Laminate Series',
                'sku' => 'LAM-CL-001',
                'description' => 'Durable laminate flooring with AC4 rating',
                'buyer_price' => 2.75,
                'vip_buyer_price' => 2.48,
                'commercial_buyer_price' => 2.20,
                'colors' => ['Light Oak', 'Dark Oak', 'Gray'],
                'sizes' => ['8\"'],
                'stock_quantity' => 1500,
                'is_featured' => true
            ],
            [
                'category' => 'Tile & Stone',
                'name' => 'Porcelain Tile Collection',
                'sku' => 'TIL-POR-001',
                'description' => 'Premium porcelain tiles for floors and walls',
                'buyer_price' => 6.99,
                'vip_buyer_price' => 6.29,
                'commercial_buyer_price' => 5.59,
                'colors' => ['White', 'Gray', 'Beige', 'Black'],
                'sizes' => ['12\"x12\"', '18\"x18\"', '24\"x24\"'],
                'stock_quantity' => 800,
                'is_featured' => true
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'description' => $productData['description'],
                    'buyer_price' => $productData['buyer_price'],
                    'vip_buyer_price' => $productData['vip_buyer_price'] ?? null,
                    'commercial_buyer_price' => $productData['commercial_buyer_price'] ?? null,
                    'discount_price' => $productData['discount_price'] ?? null,
                    'colors' => $productData['colors'],
                    'sizes' => $productData['sizes'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'is_active' => true,
                    'is_featured' => $productData['is_featured'] ?? false
                ]);
            }
        }
    }
}
