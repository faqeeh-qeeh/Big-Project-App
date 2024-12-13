<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Product extends Model  
{  
    use HasFactory;  

    protected $fillable = [  
        'product_id',  
        'name',  
        'purchase_price',  
        'selling_price',  
        'description',  
        'image',
        'category_product'
    ];  
    
    // Relasi dengan model Stock  
    public function stock()  
    {  
        return $this->hasOne(Stock::class);  
    }  

        public function getProfitAttribute()  
    {  
        return ($this->selling_price - $this->purchase_price) * ($this->stock->quantity ?? 0);  
    }  
     
    public function getPotentialLossAttribute()  
    {  
        // Misalnya, loss jika produk tidak terjual dalam waktu tertentu, dll.  
        return 0; // Ganti dengan logika perhitungan loss Anda  
    }  
    
    public function getTotalSalesAttribute() {  
        // ambil dari tabel orders dan order_items dan jumlahkan penjualan untuk setiap produk  
        return $this->orders_items->sum('quantity') * $this->selling_price;  
    
    }  
    
    public function getTotalProfitAttribute() {  
        // ambil total penjualan dikurangi dengan harga beli dikali dengan total penjualan  
        return $this->total_sales - ($this->purchase_price * $this->orders_items->sum('quantity'));  
    }  

    public function packages()  
    {  
        return $this->belongsToMany(Package::class, 'package_product');  
    }
}