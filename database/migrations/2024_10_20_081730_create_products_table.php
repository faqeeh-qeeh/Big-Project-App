<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

class CreateProductsTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('products', function (Blueprint $table) {  
            $table->id(); 
            $table->string('product_id');  
            $table->string('name'); 
            $table->decimal('purchase_price', 10, 2);  
            $table->decimal('selling_price', 10, 2);  
            $table->text('description'); 
            $table->string('image')->nullable(); 
            $table->timestamps();  
        });  
    }  

    public function down()  
    {  
        Schema::dropIfExists('products');  
    }  
}
