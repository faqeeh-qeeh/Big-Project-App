<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;  
use Illuminate\Support\Facades\Storage;  
use App\Models\Stock;  
use Jenssegers\Agent\Agent;
use App\Helpers\MqttHelper;
use Illuminate\Support\Facades\Log;
use App\Models\RelayStatus;
use App\Models\Package;  


class StoreController extends Controller
{
    // Method untuk menampilkan halaman switch (tugas.blade.php)
    public function showTugas()  
    {   
        $agent = new Agent();  
        $isMobile = $agent->isMobile();  
    
        // Ambil atau buat store pertama  
        $store = Store::firstOrCreate(  
            ['name' => 'KANJENG MAMI'],   
            ['is_open' => false]  
        );  
    
        // Ambil atau buat relay status  
        $relayStatus = RelayStatus::firstOrCreate(  
            [], // Tidak perlu kondisi spesifik  
            ['is_on' => false]  
        );  
    
        // Judul halaman  
        $title = "Tugas Toko";  
    
        // Render view dengan data  
        return view('admin.products.tugas', [  
            'store' => $store,   
            'title' => $title,   
            'isMobile' => $isMobile,   
            'status' => $relayStatus->is_on  
        ]);
    }  

    // Method untuk menampilkan halaman pengunjung (KanjengMami.blade.php)
    public function showKanjengMami()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $store = Store::first();
        $slug = "home";
        // Jika tidak ada data store, buat data baru dengan default 'is_open' = false
        if (!$store) {
            $store = Store::create(['name' => 'KANJENG MAMI', 'is_open' => false]);
        }

        // return view('layouts.KanjengMami', compact('store'));
        return view('mitra.KanjengMami', compact('store', 'slug', 'isMobile'));
    }


    // Method untuk mengubah status buka/tutup
    public function toggleStatus(Request $request)  
    {  
        // Validasi input  
        $request->validate([  
            'status' => 'required|boolean'  
        ]);  

        try {  
            // Ambil store pertama  
            $store = Store::first();  

            // Update status  
            $store->is_open = $request->input('status');  
            $store->save();  

            // Log aktivitas (opsional)  
            Log::info("Store status changed to: " . ($store->is_open ? 'Open' : 'Closed'));  

            // Kirim notifikasi MQTT (opsional)  
            $mqttTopic = config('mqtt.store_status_topic');  
            $mqttMessage = $store->is_open ? 'OPEN' : 'CLOSED';  
            
            MqttHelper::publishMessage($mqttTopic, $mqttMessage);  

            // Respon JSON  
            return response()->json([  
                'status' => $store->is_open ? 'buka' : 'tutup',  
                'success' => true,  
                'message' => 'Status toko berhasil diperbarui'  
            ]);  

        } catch (\Exception $e) {  
            // Tangani error  
            Log::error('Toggle Store Error: ' . $e->getMessage());  

            return response()->json([  
                'status' => 'error',  
                'success' => false,  
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()  
            ], 500);  
        }  
    }  
    public function toggleRelay(Request $request)  
    {  
        $request->validate([  
            'status' => 'required|boolean'  
        ]);  
    
        try {  
            // Ambil atau buat relay status  
            $relayStatus = RelayStatus::first() ??   
                RelayStatus::create(['is_on' => false]);  
    
            // Update status relay di database  
            $relayStatus->is_on = $request->input('status');  
            $relayStatus->save();  
    
            // Topic MQTT untuk relay  
            $topic = "polindra/matkuliot/relay/kel4TI2C";  
            
            // Kirim pesan MQTT  
            $message = $request->status ? "ON" : "OFF";  
            
            $result = MqttHelper::publishMessage($topic, $message);  
    
            // Log aktivitas  
            Log::info("Relay status changed to: " . ($relayStatus->is_on ? 'ON' : 'OFF'));  
    
            // Respon JSON  
            return response()->json([  
                'success' => $result,  
                'status' => $relayStatus->is_on,  
                'message' => $result   
                    ? "Relay berhasil di-{$message}"   
                    : 'Gagal mengontrol relay'  
            ]);  
    
        } catch (\Exception $e) {  
            Log::error('Relay Toggle Error: ' . $e->getMessage());  
            
            return response()->json([  
                'success' => false,  
                'status' => false,  
                'message' => 'Kesalahan sistem: ' . $e->getMessage()  
            ], 500);  
        }  
    } 

    public function products(Request $request)  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $store = Store::first();
        $slug = "products";
        $packages = Package::with('products')->get();  
        // Jika tidak ada data store, buat data baru dengan default 'is_open' = false
        if (!$store) {
            $store = Store::create(['name' => 'KANJENG MAMI', 'is_open' => false]);
        }
        // Mengambil semua produk (sesuaikan dengan kebutuhan Anda)  
        $products = Product::all();  
        $query = $request->input('search');
        

        if ($query) {
            // Ambil semua produk tanpa pagination untuk menghitung total profit
            $allProducts = Product::with('stock')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('category_product', 'like', "%{$query}%")
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->get();
        
            // Terapkan pagination pada hasil pencarian
            $products = Product::with('stock')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('category_product', 'like', "%{$query}%")
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->paginate(100);
        } else {
            // Ambil semua produk tanpa pagination untuk menghitung total profit
            $allProducts = Product::with('stock')
                ->orderBy('name', 'asc')
                ->get();
        
            // Terapkan pagination pada semua produk
            $products = Product::with('stock')
                ->orderBy('name', 'asc')
                ->paginate(100);
        }
        return view('mitra.products', compact('products', 'store', 'slug', 'isMobile', 'packages'));  
    }  

    public function detailProduct($id)  
    {  
        $agent = new \Jenssegers\Agent\Agent();  
        $isMobile = $agent->isMobile();  
        $store = Store::first();  
        
        // Mengambil produk berdasarkan ID  
        $product = Product::findOrFail($id);  
        
        // Ambil produk yang memiliki kategori yang sama  
        $products = Product::where('category_product', $product->category_product)->where('id', '!=', $product->id)->get();  
    
        return view('mitra.detailproduct', compact('product', 'isMobile', 'store', 'products'));  
    }
}
