<?php

// namespace App\Http\Controllers;  

// use App\Models\SensorData;  
// use App\Models\CostAgregate;  
// use Illuminate\Http\Request;  

// class EnergyController extends Controller  
// {  
//     public function index()  
//     {  
//         $agent = new \Jenssegers\Agent\Agent();
//         $isMobile = $agent->isMobile();
//         $title = 'Paket';
//         return view('admin.energy.index', ['title' => 'Energy Monitoring', 'isMobile' => $isMobile]);  
//     }  

//     public function getSensorData()  
//     {  
//         $data = SensorData::orderBy('timestamp', 'desc')->take(60)->get();  
//         $latest = $data->first();  
//         return response()->json(['data' => $data, 'latest' => $latest]);  
//     }  

//     public function getMinuteCosts()  
//     {  
//         $costs = CostAgregate::where('period_type', 'minute')->orderBy('timestamp', 'desc')->take(1)->get();  
//         return response()->json($costs);  
//     }  

//     public function getHourlyCosts()  
//     {  
//         $costs = CostAgregate::where('period_type', 'hour')->orderBy('timestamp', 'desc')->take(1)->get();  
//         return response()->json($costs);  
//     }  

//     public function getDailyCosts()  
//     {  
//         $costs = CostAgregate::where('period_type', 'day')->orderBy('timestamp', 'desc')->take(1)->get();  
//         return response()->json($costs);  
//     }  
// }