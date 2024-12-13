<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MqttHelper;

class ActuatorController extends Controller
{
    public function index()  
    {  
        $agent = new \Jenssegers\Agent\Agent();  
        $isMobile = $agent->isMobile();  
        $title = "Tugas";  
        
        return view('admin.products.tugas', [  
            'status' => false,  
            'title' => $title,  
            'isMobile' => $isMobile  
        ]); // Status default: Mati  
    }
    
    public function toggle(Request $request)
    {
        $status = $request->status; // Ambil status dari checkbox
        $message = $status ? "ON" : "OFF";

        $topic = "polindra/matkuliot/relay/kel4TI2C";

        if (MqttHelper::publishMessage($topic, $message)) {
            return response()->json(['success' => true, 'message' => "{$message}, alat berhasil diaktifkan."]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengaktifkan alat.']);
    }
    
}
