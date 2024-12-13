<?php

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Cart extends Model  
{  
    use HasFactory;  

    protected $fillable = ['client_id', 'product_id', 'quantity'];  

    // Relasi ke Client (bukan user)  
    public function client()  
    {  
        return $this->belongsTo(Client::class);  
    }  

    // Relasi ke Produk  
    public function product()  
    {  
        return $this->belongsTo(Product::class);  
    }  
}