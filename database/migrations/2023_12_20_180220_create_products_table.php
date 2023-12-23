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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('barcode', 15)->unique()->nullable();
            $table->string('name')->unique();
            $table->decimal('stock_initial', 12, 2)->default(0);
            $table->decimal('stock_min', 12, 2)->default(5);
            $table->decimal('purchase_price', 12, 4);
            $table->decimal('sale_price', 12, 2);
            $table->decimal('wholesale_price', 12, 2);
            $table->decimal('wholesale_quantity', 12, 2);
            $table->boolean('is_active')->default(1);
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('unit_id')->references('id')->on('units');
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
