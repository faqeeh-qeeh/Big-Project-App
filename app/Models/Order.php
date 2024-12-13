<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'order_id',
        'status',
        'amount',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    // public function product()  
    // {  
    //     return $this->belongsTo(Product::class);  
    // } 

    // public function stock()  
    // {  
    //     return $this->hasOne(Stock::class);  
    // }  

    // public function profits()  
    // {  
    //     return $this->hasMany(Profit::class);  
    // } 

    // public function items()
    // {
    //     return $this->hasMany(Profit::class);
    // }
    public const STATUSES = [  
        'pending' => 'Pending',  
        'sedang_dikemas' => 'Sedang Dikemas',  
        'produk_siap' => 'Produk Siap',  
        'sudah_diambil' => 'Sudah Diambil',  
        'cancel' => 'Dibatalkan'  
    ]; 
}
