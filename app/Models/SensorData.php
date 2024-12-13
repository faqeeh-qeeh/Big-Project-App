<?php  
namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class SensorData extends Model  
{  
    use HasFactory;  

    protected $table = 'sensor_data'; // Specify the table name if it isn't the plural form of the model  

    protected $fillable = [  
        'timestamp',  
        'voltage',  
        'current',  
        'power',  
        'energy',  
        'frequency',  
        'power_factor',  
    ];  

    // Optionally, you can add accessor methods for formatted values  
    public function getFormattedVoltageAttribute()  
    {  
        return "{$this->voltage} V";  
    }  

    public function getFormattedCurrentAttribute()  
    {  
        return "{$this->current} A";  
    }  

    public function getFormattedPowerAttribute()  
    {  
        return "{$this->power} W";  
    }  

    public function getFormattedEnergyAttribute()  
    {  
        return "{$this->energy} Wh";  
    }  

    public function getFormattedFrequencyAttribute()  
    {  
        return "{$this->frequency} Hz";  
    }  

    public function getFormattedPowerFactorAttribute()  
    {  
        return number_format($this->power_factor, 2);  
    }  
}