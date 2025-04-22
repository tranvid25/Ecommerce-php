<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_brand');
            $table->boolean('status')->default(0); // 0: new, 1: sale
            $table->integer('sale')->default(0); // <= Giá sale mặc định 0
            $table->string('company')->nullable();
            $table->text('hinhanh')->nullable(); // dùng JSON string
            $table->timestamps();
    
            // Optional: Foreign Keys
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('cascade');
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
