<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

class AddGenderAndPhoneToClientsTable extends Migration  
{  
    public function up()  
    {  
        Schema::table('clients', function (Blueprint $table) {  
            $table->enum('gender', ['male', 'female'])->after('birth_date');  
            $table->string('phone')->nullable()->after('gender');
        });  
    }  

    public function down()  
    {  
        Schema::table('clients', function (Blueprint $table) {  
            $table->dropColumn('gender');
            $table->dropColumn('phone');
        });  
    }  
}