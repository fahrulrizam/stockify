<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('stock')->default(0);
            $table->decimal('price', 15, 2);
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->string('image')->nullable();
            $table->timestamps();

            // Jika ingin pakai foreign key (opsional)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
