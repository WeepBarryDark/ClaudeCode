<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->decimal('buyer_price', 10, 2);
            $table->decimal('vip_buyer_price', 10, 2)->nullable();
            $table->decimal('commercial_buyer_price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('area_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
