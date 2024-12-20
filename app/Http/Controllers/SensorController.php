<?php  
// namespace App\Http\Controllers;  

// use App\Models\SensorData;  
// use App\Models\AggregatedData;
// use Illuminate\Http\Request;  
// use Carbon\Carbon;
// // use App\Events\NewSensorData;  
// use Illuminate\Console\Scheduling\Schedule;


// class SensorController extends Controller  
// {  
//     public function index()  
//     {  
//         $title = "Monitoring";
//         $agent = new \Jenssegers\Agent\Agent();
//         $isMobile = $agent->isMobile();
//         return view('admin.iot.monitoring', compact('title', 'isMobile'));  
//     }  

//     public function getData()  
//     {  
//         $latestData = SensorData::latest('timestamp')  
//             ->take(10)  
//             ->get();  

//         return response()->json([  
//             'data' => $latestData,  
//             'latest' => $latestData->first()  
//         ]);  
//     }  

//     public function processIncomingData(Request $request)  
//     {  
//         $validatedData = $request->validate([  
//             'voltage' => 'required|numeric',  
//             'current' => 'required|numeric',  
//             'power' => 'required|numeric',
//             'energy' => 'required|numeric',
//             'frequency' => 'required|numeric',
//             'power_factor' => 'required|numeric'
//         ]);  

//         $sensorData = SensorData::create([  
//             'timestamp' => now(),  
//             ...$validatedData  
//         ]);  

//         // broadcast(new NewSensorData($sensorData))->toOthers();  

//         // return response()->json($sensorData, 201);  
//     }  

    
//     public function getMinuteCosts()  
//     {  
//         $minuteCosts = AggregatedData::where('interval_type', 'minute')  
//             ->where('interval_start', '>=', now()->subHour())  
//             ->orderBy('interval_start', 'desc')  
//             ->get(['interval_start', 'total_energy_cost']);  

//         return response()->json($minuteCosts);  
//     }  

//     public function getHourlyCosts()  
//     {  
//         $hourlyCosts = AggregatedData::where('interval_type', 'hour')  
//             ->where('interval_start', '>=', now()->subDay())  
//             ->orderBy('interval_start', 'desc')  
//             ->get(['interval_start', 'total_energy_cost']);  

//         return response()->json($hourlyCosts);  
//     }  

//     public function getDailyCosts()  
//     {  
//         $dailyCosts = AggregatedData::where('interval_type', 'day')  
//             ->where('interval_start', '>=', now()->subMonth())  
//             ->orderBy('interval_start', 'desc')  
//             ->get(['interval_start', 'total_energy_cost']);  

//         return response()->json($dailyCosts);  
//     }  


//     public function aggregateData()
//     {
//         $currentTime = Carbon::now();
//         $threeSecondsAgo = $currentTime->subSeconds(3);

//         $sensorData = SensorData::where('timestamp', '>=', $threeSecondsAgo)->get();

//         if ($sensorData->isEmpty()) {
//             return response()->json(['message' => 'No data to aggregate'], 204);
//         }

//         $totalPower = $sensorData->sum('power'); // Daya dalam watt
//         $energyInKWh = ($totalPower * (3 / 3600)) / 1000; // Energi dalam kWh
//         $tariff = 1444.70; // Tarif dasar listrik PLN (contoh)

//         $totalCost = $energyInKWh * $tariff;

//         AggregatedData::create([
//             'interval_type' => 'minute', // Anda dapat mengubah ke 'hour' atau 'day'
//             'interval_start' => $threeSecondsAgo,
//             'total_energy' => $energyInKWh,
//             'total_energy_cost' => $totalCost,
//         ]);

//         return response()->json(['total_cost' => $totalCost], 201);
//     }


//     protected function schedule(Schedule $schedule)
//     {
//         $schedule->call(function () {
//             app(SensorController::class)->aggregateData();
//         })->everyThreeSeconds();
//     }

// }