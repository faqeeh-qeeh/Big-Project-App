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
        Schema::create('package_product', function (Blueprint $table) {  
            $table->id(); // Primary Key  
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade'); // FK ke Packages  
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // FK ke Products  
            $table->integer('quantity'); // Jumlah Produk dalam Paket  
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_product');
    }
};
