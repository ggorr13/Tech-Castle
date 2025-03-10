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
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            // Better to use decimals, as shop can sell 560.20 g sugar or whatever
            $table->integer('quantity');
            // this is the exact place where enum could be used
            $table->enum('type',['physical', 'digital']); // 'physical' or 'digital'
            $table->decimal('price_with_tax', 8, 2)->nullable();

            // Physical product properties
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();

            // Digital product properties
            $table->string('download_url')->nullable();

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
