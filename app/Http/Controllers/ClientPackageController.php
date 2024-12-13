<?php

namespace App\Http\Controllers;  

use App\Models\Package;  
use App\Models\Cart;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ClientPackageController extends Controller  
{  
    // Menampilkan semua paket  
    public function index()  
    {  
        $packages = Package::with('products')->get();  
        return view('client.packages.index', compact('packages'));  
    }  

    // Menambah semua produk dari paket ke cart  
    public function addToCart(Request $request, Package $package)  
    {  
        $clientId = auth('client')->id(); // Ambil ID client yang sedang login
    
        // Pastikan client terautentikasi
        if (!$clientId) {
            return redirect()->route('client.login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Periksa apakah paket memiliki produk
        if ($package->products->isEmpty()) {
            return redirect()->route('client.packages.index')->with('error', 'Paket tidak memiliki produk.');
        }
    
        foreach ($package->products as $product) {  
            Cart::updateOrCreate(  
                [  
                    'client_id' => $clientId, // Client ID  
                    'product_id' => $product->id  
                ],  
                [  
                    'quantity' => DB::raw("quantity + {$product->pivot->quantity}"), // Tambahkan jumlah produk sesuai paket
                ]  
            );  
        }  
    
        return redirect()->route('cart.index')->with('success', 'Paket berhasil ditambahkan ke keranjang!');  
    }

    
}