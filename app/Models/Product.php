<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'images',
        'buyer_price',
        'vip_buyer_price',
        'commercial_buyer_price',
        'discount_price',
        'sizes',
        'colors',
        'stock_quantity',
        'area_code',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'sizes' => 'array',
            'colors' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'buyer_price' => 'decimal:2',
            'vip_buyer_price' => 'decimal:2',
            'commercial_buyer_price' => 'decimal:2',
            'discount_price' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function getPriceForRole($role)
    {
        return match($role) {
            'vip_buyer' => $this->vip_buyer_price ?? $this->buyer_price,
            'commercial_buyer' => $this->commercial_buyer_price ?? $this->buyer_price,
            default => $this->buyer_price
        };
    }

    public function getDisplayPrice($role = 'buyer')
    {
        $price = $this->getPriceForRole($role);
        return $this->discount_price && $this->discount_price < $price ? $this->discount_price : $price;
    }
}
