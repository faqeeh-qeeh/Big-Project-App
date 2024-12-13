<?php  

namespace App\Models;  

use Illuminate\Foundation\Auth\User as Authenticatable;  
use Illuminate\Notifications\Notifiable;  

class Admin extends Authenticatable  
{  
    use Notifiable;  

    // Table name (optional if the table is named `admins`)  
    protected $table = 'admins';  

    // Mass assignable attributes  
    protected $fillable = [  
        'name',  
        'email',  
        'password',  
    ];  

    // Attributes to hide from arrays (like JSON response or debug)  
    protected $hidden = [  
        'password',  
        'remember_token',  
    ];  
}