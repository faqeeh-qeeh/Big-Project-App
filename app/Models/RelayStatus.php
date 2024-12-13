<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class RelayStatus extends Model  
{  
    use HasFactory;  

    protected $fillable = ['is_on'];  
}