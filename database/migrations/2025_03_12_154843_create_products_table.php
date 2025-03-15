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
            $table->unsignedBigInteger('owner_id');
            $table->char('title', 255);
            $table->text('description');
            $table->char('thumbnail_url')->nullable();
            $table->char('demo_url')->nullable();
            $table->char('source_url')->nullable();
            $table->unsignedInteger('price');
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('owner_id')->references('id')->on('users');
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
