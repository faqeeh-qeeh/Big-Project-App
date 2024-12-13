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
        Schema::create('packages', function (Blueprint $table) {  
            $table->id(); // Primary Key  
            $table->string('name'); // Nama Paket  
            $table->string('description')->nullable(); // Deskripsi Paket  
            $table->decimal('total_price', 10, 2); // Harga Total Paket  
            $table->timestamps(); // Created_At dan Updated_At  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
