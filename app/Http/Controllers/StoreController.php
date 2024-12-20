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
    public function showTugas()  
    {   
        $agent = new Agent();  
        $isMobile = $agent->isMobile();  
        $store = Store::firstOrCreate(  
            ['name' => 'KANJENG MAMI'],   
            ['is_open' => false]  
        );   
        $relayStatus = RelayStatus::firstOrCreate(  
            [],
            ['is_on' => false]  
        );  
        $title = "Tugas Toko";  
        return view('admin.products.tugas', [  
            'store' => $store,   
            'title' => $title,   
            'isMobile' => $isMobile,   
            'status' => $relayStatus->is_on  
        ]);
    }  

    public function showKanjengMami()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $store = Store::first();
        $slug = "home";
        if (!$store) {
            $store = Store::create(['name' => 'KANJENG MAMI', 'is_open' => false]);
        }
        return view('mitra.KanjengMami', compact('store', 'slug', 'isMobile'));
    }

    public function toggleStatus(Request $request)  
    {  
        $request->validate([  
            'status' => 'required|boolean'  
        ]);  

        try {  
            $store = Store::first();  
            $store->is_open = $request->input('status');  
            $store->save();  
            Log::info("Store status changed to: " . ($store->is_open ? 'Open' : 'Closed'));   
            $mqttTopic = config('mqtt.store_status_topic');  
            $mqttMessage = $store->is_open ? 'OPEN' : 'CLOSED';  
            MqttHelper::publishMessage($mqttTopic, $mqttMessage);  
            return response()->json([  
                'status' => $store->is_open ? 'buka' : 'tutup',  
                'success' => true,  
                'message' => 'Status toko berhasil diperbarui'  
            ]);  

        } catch (\Exception $e) {  
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
            $relayStatus = RelayStatus::first() ??   
                RelayStatus::create(['is_on' => false]);  
            $relayStatus->is_on = $request->input('status');  
            $relayStatus->save();   
            $topic = "polindra/matkuliot/relay/kel4TI2C";  
            $message = $request->status ? "ON" : "OFF";  
            $result = MqttHelper::publishMessage($topic, $message);  
            Log::info("Relay status changed to: " . ($relayStatus->is_on ? 'ON' : 'OFF'));  
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

    // public function products(Request $request)  
    // {  
    //     $agent = new \Jenssegers\Agent\Agent();
    //     $isMobile = $agent->isMobile();
    //     $store = Store::first();
    //     $slug = "products";
    //     $packages = Package::with('products')->get();  
    //     // Jika tidak ada data store, buat data baru dengan default 'is_open' = false
    //     if (!$store) {
    //         $store = Store::create(['name' => 'KANJENG MAMI', 'is_open' => false]);
    //     }
    //     // Mengambil semua produk (sesuaikan dengan kebutuhan Anda)  
    //     $products = Product::all();  
    //     $query = $request->input('search');
        

    //     if ($query) {
    //         // Ambil semua produk tanpa pagination untuk menghitung total profit
    //         $allProducts = Product::with('stock')
    //             ->where('name', 'like', "%{$query}%")
    //             ->orWhere('category_product', 'like', "%{$query}%")
    //             ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
    //             ->get();
        
    //         // Terapkan pagination pada hasil pencarian
    //         $products = Product::with('stock')
    //             ->where('name', 'like', "%{$query}%")
    //             ->orWhere('category_product', 'like', "%{$query}%")
    //             ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
    //             ->paginate(100);
    //     } else {
    //         // Ambil semua produk tanpa pagination untuk menghitung total profit
    //         $allProducts = Product::with('stock')
    //             ->orderBy('name', 'asc')
    //             ->get();
        
    //         // Terapkan pagination pada semua produk
    //         $products = Product::with('stock')
    //             ->orderBy('name', 'asc')
    //             ->paginate(100);
    //     }
    //     return view('mitra.products', compact('products', 'store', 'slug', 'isMobile', 'packages'));  
    // }  

    
    public function products(Request $request)  
    {  
        $agent = new \Jenssegers\Agent\Agent();  
        $isMobile = $agent->isMobile();  
        $store = Store::first();  
        $packages = Package::with('products')->get();  
        $slug = "products";
        $query = $request->input('search');  
        $showAll = $request->boolean('show_all');  
        $perPage = $showAll ? 1000 : 12;  
        $productsQuery = Product::with('stock')  
            ->when($query, function($q) use ($query) {  
                return $q->where('name', 'like', "%{$query}%")  
                        ->orWhere('category_product', 'like', "%{$query}%");  
            })  
            ->orderBy('name', 'asc');  
        $products = $productsQuery->paginate($perPage);  
        $products->appends(['show_all' => $showAll, 'search' => $query]);  
        return view('mitra.products', compact(  
            'products',   
            'store',   
            'isMobile',   
            'packages',   
            'showAll',  
            'slug'
        ));  
    }

    public function detailProduct($id)  
    {  
        $agent = new \Jenssegers\Agent\Agent();  
        $isMobile = $agent->isMobile();  
        $store = Store::first();  
        $product = Product::findOrFail($id);   
        $products = Product::where('category_product', $product->category_product)->where('id', '!=', $product->id)->get();  
        return view('mitra.detailproduct', compact('product', 'isMobile', 'store', 'products'));  
    }
}
