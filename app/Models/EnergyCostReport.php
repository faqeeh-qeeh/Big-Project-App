<?php

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class EnergyCostReport extends Model  
{  
    use HasFactory;  

    protected $fillable = ['total_energy_cost'];  
}