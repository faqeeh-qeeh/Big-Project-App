<?php

namespace App\Http\Controllers;  

use App\Models\Product;  
use App\Models\Stock;  
use App\Models\Profit;  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Storage;  
use Jenssegers\Agent\Agent;

class ProductController extends Controller  
{  
    public function create()  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $title = "Tambah Data";
        $slug = "create";
        return view('admin.products.create', compact( 'title', 'slug', 'isMobile'));  
    }  

    public function store(Request $request)  
    {  
        $request->validate([  
            'product_id' => 'required|string|max:255',  
            'name' => 'required|string|max:255',  
            'purchase_price' => 'required|numeric',  
            'selling_price' => 'required|numeric',  
            'description' => 'required|string',  
            'image' => 'image|nullable',  
            'category_product' => 'required|string|max:255',
        ]);  

        $product = new Product();  
        $product->product_id = $request->product_id;  
        $product->name = $request->name;  
        $product->purchase_price = $request->purchase_price;  
        $product->selling_price = $request->selling_price;  
        $product->description = $request->description;  
        $product->category_product = $request->category_product;

        if ($request->hasFile('image')) {  
            $path = $request->file('image')->store('images/products', 'public');  
            $product->image = $path;  
        }  

        $product->save();  

        // Simpan stok produk  
        $stock = new Stock();  
        $stock->product_id = $product->id; // ID dari produk yang baru disimpan  
        $stock->quantity = $request->input('quantity', 0); // Ambil total dari input atau default 0  
        $stock->save();  

        return redirect()->route('admin.products.create')->with('success', 'Produk '. $product->name.' berhasil ditambahkan'); 
        
        // $title = "Tambah Data";
        // $slug = "create";
        // return view('products.create', compact( 'title', 'slug'));  
    }

    public function index(Request $request)  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $title = 'Products';
        $slug = 'products';
        $query = $request->input('search');

        if ($query) {
            // Ambil semua produk tanpa pagination untuk menghitung total profit
            $allProducts = Product::with('stock')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('product_id', 'like', "%{$query}%")
                ->orWhere('category_product', 'like', "%{$query}%")
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->get();
        
            // Terapkan pagination pada hasil pencarian
            $products = Product::with('stock')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('product_id', 'like', "%{$query}%")
                ->orWhere('category_product', 'like', "%{$query}%")
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->paginate(10);
        } else {
            // Ambil semua produk tanpa pagination untuk menghitung total profit
            $allProducts = Product::with('stock')
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->get();
        
            // Terapkan pagination pada semua produk
            $products = Product::with('stock')
                ->orderBy('name', 'asc') // Urutkan data berdasarkan abjad nama
                ->paginate(10);
        }

        // Hitung total keuntungan dari semua produk
        $totalProfit = $allProducts->sum(function($product) {
            $quantity = optional($product->stock)->quantity ?? 0;
            return ($product->selling_price - $product->purchase_price) * $quantity;
        });        

        return view('admin.products.read', compact('products', 'title', 'slug', 'totalProfit', 'isMobile'));
    }


    public function edit($id)  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $product = Product::findOrFail($id);  
        return view('admin.products.edit', compact('product', 'isMobile'));  
    }

    public function update(Request $request, $id)  
    {  
        
        $request->validate([  
            'product_id' => 'required|string|max:255',  
            'name' => 'required|string|max:255',  
            'purchase_price' => 'required|numeric',  
            'selling_price' => 'required|numeric',  
            'description' => 'required|string',  
            'image' => 'image|nullable',  
            'category_product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',  // Validasi kuantitas stok  
            'action' => 'required|string|in:add,subtract', // Menambahkan aksi untuk menambah/kurangi stok  
        ]);  
    
        $product = Product::findOrFail($id);  
        $product->product_id = $request->product_id;  
        $product->name = $request->name;  
        $product->purchase_price = $request->purchase_price;  
        $product->selling_price = $request->selling_price;  
        $product->description = $request->description;  
        $product->category_product = $request->category_product;
    
        if ($request->hasFile('image')) {  
            if ($product->image) {  
                Storage::disk('public')->delete($product->image);  
            }  
            $path = $request->file('image')->store('images/products', 'public');  
            $product->image = $path;  
        }  
    
        $product->save();  
        $stock = Stock::firstOrCreate(  
            ['product_id' => $product->id],  
            ['quantity' => 0]
        );  
    
        if ($request->action === 'add') {  
            $stock->quantity += $request->quantity;  
    
            $profitAmount = $request->quantity * ($product->selling_price - $product->purchase_price);  
            Profit::create(['product_id' => $product->id, 'amount' => $profitAmount]);  
        } elseif ($request->action === 'subtract') {  
            // Mengurangi stok  
            if ($stock->quantity >= $request->quantity) {  
                $stock->quantity -= $request->quantity;  
            } else {  
                return redirect()->route('admin.products.read')->with('error', 'Stok tidak cukup untuk dikurangi');  
            }  
        }  
    
        $stock->save(); // Simpan perubahan stok  
    
        return redirect()->route('admin.products.read')->with('success', 'Produk ' . $product->name . ' berhasil diperbarui');  
    }

    public function destroy($id)  
    {  
        $product = Product::findOrFail($id);  
        // Hapus gambar dari penyimpanan  
        if ($product->image) {  
            Storage::disk('public')->delete($product->image);  
        }  
        $product->delete();  
    
        return redirect()->route('admin.products.read')->with('success', 'Produk ' . $product->name .  ' berhasil dihapus');  
    }

    public function search(Request $request)  
    {  
        $query = $request->input('query');  
        
        $products = Product::with('stock') // Tambahkan relasi stock  
            ->where(function($q) use ($query) {  
                $q->where('name', 'LIKE', "%{$query}%")  
                  ->orWhere('product_id', 'LIKE', "%{$query}%")  
                  ->orWhere('category_product', 'LIKE', "%{$query}%");  
            })  
            ->limit(10)  
            ->get()  
            ->map(function($product) {  
                return [  
                    'id' => $product->id,  
                    'name' => $product->name,  
                    'product_id' => $product->product_id,  
                    'image' => $product->image,  
                    'stock' => optional($product->stock)->quantity ?? 0,  
                    'selling_price' => $product->selling_price  
                ];  
            });  
        
        return response()->json($products);  
    }
}