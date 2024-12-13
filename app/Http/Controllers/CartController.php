<?php

namespace App\Http\Controllers;  

use App\Models\Cart;  
use App\Models\Product;  
use App\Models\Client; // Jika perlu  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth;  
use Jenssegers\Agent\Agent;


class CartController extends Controller  
{  
    // Menampilkan Keranjang Belanja  
    public function index(Request $request)  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $clientId = Auth::guard('client')->id();
        // $clientId = $request->session()->get('client_id'); // Alternatif menggunakan sesi  

        $cartItems = Cart::where('client_id', $clientId)->with('product')->get();  
        $totalPrice = $cartItems->sum(function ($cart) {  
            return $cart->product->selling_price * $cart->quantity;  
        });  

        return view('cart.index', compact('cartItems', 'totalPrice', 'isMobile'));  
    }  

    public function addToCart(Request $request, $productId)  
    {  
        // Periksa otentikasi atau sesi untuk mendapatkan client_id  
        $clientId = Auth::guard('client')->id(); // Jika menggunakan autentikasi Client  
        // $clientId = $request->session()->get('client_id'); // Jika menggunakan sesi  

        if (!$clientId) {  
            return redirect()->route('client.login')->with('error', 'Silakan login terlebih dahulu.');  
        }  

        $product = Product::findOrFail($productId);  

        $cartItem = Cart::where('client_id', $clientId)  
            ->where('product_id', $productId)  
            ->first();  

        if ($cartItem) {  
            // Tambahkan jumlah item  
            $cartItem->quantity += 1;  
            $cartItem->save();  
        } else {  
            // Tambahkan produk baru ke keranjang  
            Cart::create([  
                'client_id' => $clientId,  
                'product_id' => $productId,  
                'quantity' => 1,  
            ]);  
        }  

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');  
    }  

    // Update Jumlah Produk dalam Keranjang  
    public function updateQuantity(Request $request, $cartId)  
    {  
        $cartItem = Cart::findOrFail($cartId);  

        if ($request->quantity > 0) {  
            $cartItem->quantity = $request->quantity;  
            $cartItem->save();  
        } else {  
            // Jika jumlah produk 0, hapus item dari keranjang  
            $cartItem->delete();  
        }  

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');  
    }  

    // Hapus Produk dari Keranjang  
    public function removeFromCart($cartId)  
    {  
        $cartItem = Cart::findOrFail($cartId);  
        $cartItem->delete();  

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');  
    }  
}