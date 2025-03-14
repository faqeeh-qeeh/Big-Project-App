<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

class UpdateCartTableForClient extends Migration  
{  
    public function up()  
    {  
        Schema::table('carts', function (Blueprint $table) {  
            $table->dropForeign(['user_id']);  
            $table->dropColumn('user_id');  
            $table->unsignedBigInteger('client_id')->after('id')->nullable();  
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');  
        });  
    }  

    public function down()  
    {  
        Schema::table('carts', function (Blueprint $table) {  
            $table->dropForeign(['client_id']);  
            $table->dropColumn('client_id');  
            $table->unsignedBigInteger('user_id')->after('id')->nullable();  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
        });  
    }  
}
