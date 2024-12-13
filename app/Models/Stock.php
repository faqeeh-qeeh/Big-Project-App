<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Stock extends Model  
{  
    use HasFactory;  

    protected $fillable = [  
        'product_id',  
        'quantity',  
        'profit', // Ditambahkan  
        'loss', // Ditambahkan  
    ];  

    public function product()  
    {  
        return $this->belongsTo(Product::class);  
    }  

    public function packages()  
    {  
        return $this->belongsToMany(Package::class, 'package_product');  
    }
}