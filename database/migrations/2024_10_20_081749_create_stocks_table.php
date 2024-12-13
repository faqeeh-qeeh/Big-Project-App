<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('stocks', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  
            $table->integer('quantity')->default(0);  
            $table->decimal('profit', 10, 2)->default(0); // Kolom untuk menyimpan keuntungan  
            $table->decimal('loss', 10, 2)->default(0); // Kolom untuk menyimpan kerugian  
            $table->timestamps();  
        });  
    }

    public function down()  
    {  
        Schema::dropIfExists('stocks');  
    }  
}
