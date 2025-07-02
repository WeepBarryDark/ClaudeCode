<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'requested_products',
        'status',
        'shipping_cost',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_products' => 'array',
            'shipping_cost' => 'decimal:2',
        ];
    }
}
