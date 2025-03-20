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
            $table->string('name');
            $table->string('image');
            $table->decimal('import_price', 10, 2);
            $table->decimal('retail_price', 10, 2);
            $table->integer('quantity');
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('order_detail_id')->constrained('order_details')->onDelete('cascade');
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
