<?php  

namespace App\Models;  

use Illuminate\Foundation\Auth\User as Authenticatable;  
use Illuminate\Notifications\Notifiable;  

class Client extends Authenticatable  
{  
    use Notifiable;  

    // Table name  
    protected $table = 'clients';  

    // Mass assignable attributes  
    protected $fillable = [  
        'full_name',  
        'username',  
        'email',  
        'birth_date',  
        'address',  
        'password',  
        'gender', 
        'phone', 
    ];  

    // Attributes to hide from arrays  
    protected $hidden = [  
        'password',  
        'remember_token',  
    ];   

    public function carts()  
    {  
        return $this->hasMany(Cart::class);  
    } 
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}