<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardwood Flooring',
                'description' => 'Premium solid and engineered hardwood floors in various wood species',
                'sort_order' => 1
            ],
            [
                'name' => 'Luxury Vinyl Plank',
                'description' => 'Waterproof luxury vinyl planks that mimic the look of hardwood',
                'sort_order' => 2
            ],
            [
                'name' => 'Laminate Flooring',
                'description' => 'Durable and affordable laminate flooring options',
                'sort_order' => 3
            ],
            [
                'name' => 'Tile & Stone',
                'description' => 'Ceramic, porcelain, and natural stone flooring solutions',
                'sort_order' => 4
            ],
            [
                'name' => 'Carpet',
                'description' => 'Comfortable and cozy carpet options for residential and commercial use',
                'sort_order' => 5
            ],
            [
                'name' => 'Bamboo Flooring',
                'description' => 'Eco-friendly bamboo flooring with natural beauty and durability',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $category['sort_order']
            ]);
        }
    }
}
