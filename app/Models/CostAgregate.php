<?php

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class CostAgregate extends Model  
{  
    use HasFactory;  

    protected $table = 'cost_agregate'; // Specify the table name  

    protected $fillable = [  
        'period_type',  
        'timestamp',  
        'total_cost',  
    ];  

    // Optionally, you can add accessor methods for formatted values  
    public function getFormattedTotalCostAttribute()  
    {  
        return number_format($this->total_cost, 2) . ' IDR';  
    }  
}