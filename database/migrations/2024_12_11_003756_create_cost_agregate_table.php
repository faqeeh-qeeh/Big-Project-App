<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

class CreateCostAgregateTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('cost_agregate', function (Blueprint $table) {  
            $table->id();  
            $table->string('period_type');  
            $table->timestamp('timestamp');  
            $table->float('total_cost');  
            $table->unique(['period_type', 'timestamp']);  
            $table->timestamps();  
        });  
    }  

    public function down()  
    {  
        Schema::dropIfExists('cost_agregate');  
    }  
}