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
        Schema::create('carts', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users  
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke tabel products  
            $table->integer('quantity'); // Jumlah item dalam keranjang  
            $table->timestamps();  
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
