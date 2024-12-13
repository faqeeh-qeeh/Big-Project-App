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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_open')->default(false); // Menyimpan status buka/tutup
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }

};
