<?php
namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class CostAggregate extends Model  
{  
    use HasFactory;  

    protected $fillable = ['hourly_cost', 'daily_cost', 'monthly_cost'];  
}