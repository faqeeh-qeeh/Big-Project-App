<?php  

namespace App\Http\Controllers;  

use App\Models\SensorData;  
use App\Models\CostAgregate;  
use Illuminate\Http\Request;  
use Carbon\Carbon;  

class SensorDataController extends Controller  
{  
    public function index()  
    {  
        return view('admin.energy.index');  
    }  
    public function getSensorData()  
    {  
        // Pastikan Anda mengambil 10 data terakhir dengan benar  
        $sensorData = SensorData::latest('timestamp')  
            ->take(10)  
            ->get()  
            ->reverse(); // Membalik urutan data agar yang terbaru di ujung  
    
        $labels = [];  
        $voltage = [];  
        $current = [];  
        $power = [];  
        $energy = [];  
        $frequency = [];  
        $powerFactor = [];  
    
        foreach ($sensorData as $data) {  
            $labels[] = Carbon::parse($data->timestamp)->format('H:i:s');  
            $voltage[] = $data->voltage;  
            $current[] = $data->current;  
            $power[] = $data->power;  
            $energy[] = $data->energy;  
            $frequency[] = $data->frequency;  
            $powerFactor[] = $data->power_factor;  
        }  
    
        $latestData = $sensorData->last(); // Data paling akhir  
    
        return response()->json([  
            'chart' => [  
                'labels' => $labels,  
                'voltage' => $voltage,  
                'current' => $current,  
                'power' => $power,  
                'energy' => $energy,  
                'frequency' => $frequency,  
                'power_factor' => $powerFactor  
            ],  
            'latest' => [  
                'voltage' => $latestData->voltage ?? 0,  
                'current' => $latestData->current ?? 0,  
                'power' => $latestData->power ?? 0,  
                'energy' => $latestData->energy ?? 0,  
                'frequency' => $latestData->frequency ?? 0,  
                'power_factor' => $latestData->power_factor ?? 0  
            ]  
        ]);  
    }

    public function getCostData()  
    {  
        $minuteCost = CostAgregate::where('period_type', 'minute')  
            ->latest('timestamp')  
            ->first();  

        $hourCost = CostAgregate::where('period_type', 'hour')  
            ->latest('timestamp')  
            ->first();  

        $dayCost = CostAgregate::where('period_type', 'day')  
            ->latest('timestamp')  
            ->first();  

        $monthCost = CostAgregate::where('period_type', 'month')  
            ->latest('timestamp')  
            ->first();  

        return response()->json([  
            'minute' => $minuteCost ? $minuteCost->total_cost : 0,  
            'hour' => $hourCost ? $hourCost->total_cost : 0,  
            'day' => $dayCost ? $dayCost->total_cost : 0,  
            'month' => $monthCost ? $monthCost->total_cost : 0,  
        ]);  
    }  
}