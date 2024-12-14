<?php

namespace App\Http\Controllers;  

use App\Models\Package;  
use App\Models\Product;  
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdminPackageController extends Controller  
{  
    // Menampilkan semua paket  
    public function index()  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $title = 'Paket';
        $packages = Package::with('products')->get();  
        return view('admin.packages.index', compact('packages', 'title', 'isMobile'));  
    }  

    // Form untuk membuat paket baru  
    public function create()  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $title = 'Buat Paket';
        $products = Product::all(); // Semua produk untuk pilihan admin  
        return view('admin.packages.create', compact('products', 'title', 'isMobile'));  
    }  

    // Menyimpan paket baru  
    public function store(Request $request)  
    {  
        $validated = $request->validate([  
            'name' => 'required|string|max:255',  
            'description' => 'nullable|string',  
            'products' => 'required|array', // Produk wajib diisi  
            'products.*' => 'exists:products,id',  
            'quantities' => 'required|array',  
            'quantities.*' => 'integer|min:1',  
        ]);  

        // Hitung total harga paket  
        $totalPrice = 0;  
        foreach ($validated['products'] as $i => $productId) {  
            $price = Product::find($productId)->selling_price;  
            $quantity = $validated['quantities'][$i]; // Ambil kuantitas menggunakan indeks $i  
            $totalPrice += $price * $quantity;  
        }

        // Buat paket  
        $package = Package::create([  
            'name' => $validated['name'],  
            'description' => $validated['description'],  
            'total_price' => $totalPrice  
        ]);  

        // Tambahkan produk ke paket  
        foreach ($validated['products'] as $i => $productId) {  
            $package->products()->attach($productId, [  
                'quantity' => $validated['quantities'][$i],  
            ]);  
        }  

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dibuat!');  
    }  

    public function destroy(Package $package)
    {
        DB::beginTransaction();
        try {
            // Ambil data paket sebelum dihapus
            $deletedPackageData = [
                'name' => $package->name,
                'products' => $package->products->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->selling_price,
                    ];
                }),
                'total_price' => $package->total_price,
            ];
    
            // Hapus hubungan produk dan paket
            $package->products()->detach();
            $package->delete();
    
            DB::commit();
    
            // Simpan data paket ke session agar bisa ditampilkan di view
            session()->flash('deletedPackage', $deletedPackageData);
    
            return redirect()->route('admin.packages.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus paket: ' . $e->getMessage());
            return redirect()->route('admin.packages.index')->with('error', 'Gagal menghapus paket.');
        }
    }
    
    public function show(Package $package)  
    {  
        // Load relasi produk  
        $package->load('products');  
    
        return view('admin.packages.show', [  
            'package' => $package // Mengirimkan variabel package bukan packages  
        ]);  
    }

    
    public function edit(Package $package)  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $title = 'Paket';
        // Ambil semua produk untuk ditampilkan di dropdown pilihan  
        $products = Product::all();  

        // Load relasi produk untuk mendapatkan kuantitas terkait  
        $package->load('products');  

        return view('admin.packages.edit', [  
            'package' => $package,  
            'products' => $products,
            'title' => $title,
            'isMobile' => $isMobile
        ]);  
    }

    public function update(Request $request, Package $package)  
    {  
        // Validasi input  
        $validated = $request->validate([  
            'name' => [  
                'required',  
                'string',  
                'max:255',  
            ],  
            'description' => 'nullable|string|max:500',  
            'products' => 'required|array|min:1',  
            'products.*' => 'exists:products,id',  
            'quantities' => 'required|array',  
            'quantities.*' => 'integer|min:1|max:100'  
        ]);  

        // Pastikan jumlah produk dan kuantitas cocok  
        if (count($validated['products']) !== count($validated['quantities'])) {  
            return back()->with('error', 'Jumlah produk dan kuantitas harus sesuai.');  
        }  

        DB::beginTransaction(); // Memulai transaksi database  
        try {  
            // Update informasi paket  
            $package->update([  
                'name' => $validated['name'],  
                'description' => $validated['description'] ?? null  
            ]);  

            // Siapkan data untuk sinkronisasi  
            $productData = [];  
            foreach ($validated['products'] as $index => $productId) {  
                $productData[$productId] = [  
                    'quantity' => $validated['quantities'][$index]  
                ];  
            }  

            // Sinkronisasi produk dengan pivot table  
            $package->products()->sync($productData);  

            // Hitung ulang total harga paket  
            $totalPrice = 0;  
            foreach ($validated['products'] as $index => $productId) {  
                $price = Product::find($productId)->selling_price;  
                $quantity = $validated['quantities'][$index];  
                $totalPrice += $price * $quantity;  
            }  

            $package->update(['total_price' => $totalPrice]);  

            // Trigger event jika diperlukan (digunakan jika Anda memiliki event tertentu)  
            // event(new PackageUpdatedEvent($package));  

            DB::commit(); // Menyimpan perubahan dalam transaksi  
            return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui');  

        } catch (\Exception $e) {  
            DB::rollBack(); // Rollback jika terjadi error  

            // Log error untuk analisis lebih lanjut  
            Log::error('Gagal memperbarui paket: ' . $e->getMessage());  

            return back()->withInput()->with('error', 'Gagal memperbarui paket: ' . $e->getMessage());  
        }  
    }
}