<?php
use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

class CreateProfitsTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('profits', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  
            $table->decimal('amount', 10, 2); // Jumlah keuntungan  
            $table->timestamps();  
        });  
    }  

    public function down()  
    {  
        Schema::dropIfExists('profits');  
    }  
}