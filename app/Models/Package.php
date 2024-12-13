<?php

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Package extends Model  
{  
    use HasFactory;  

    protected $fillable = ['name', 'description', 'total_price'];  

    // Relasi dengan product melalui pivot table package_product  
    public function products()  
    {  
        return $this->belongsToMany(Product::class, 'package_product')  
                    ->withPivot('quantity') // Menyertakan jumlah masing-masing produk  
                    ->withTimestamps();  
    }  
}