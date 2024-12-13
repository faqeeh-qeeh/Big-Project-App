<?php

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use App\Models\Admin;  
use App\Models\Client;  
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Validator;  

class AdminController extends Controller  
{  
    // Show Admin Registration Form  
    public function showRegisterForm()  
    {  
        return view('admin.register');  
    }  

    // Handle Admin Registration  
    public function register(Request $request)  
    {  
        $validator = Validator::make($request->all(), [  
            'name' => ['required', 'string', 'max:255'],  
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],  
            'password' => ['required', 'string', 'min:8', 'confirmed'],  
        ]);  

        if ($validator->fails()) {  
            return back()->withErrors($validator)->withInput();  
        }  

        Admin::create([  
            'name' => $request->name,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
        ]);  

        return redirect()->route('admin.login')->with('success', 'Admin registered successfully. Please login.');  
    }  

    // Show Admin Login Form  
    public function showLoginForm()  
    {  
        return view('admin.login');  
    }  

    // Handle Admin Login  
    public function login(Request $request)  
    {  
        $credentials = $request->only('email', 'password');  
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();  
    
        if (!$admin) {  
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Admin tidak terdaftar.']);  
        }  
    
        if (Auth::guard('admin')->attempt($credentials)) {  
            return redirect()->route('admin.dashboard');  
        }  
    
        return back()->withInput($request->only('email'))->withErrors(['password' => 'Password salah.']);  
    }

    // Show Dashboard  
    public function dashboard()  
    {  
        $title = "Profil";
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $clients = Client::all();  
        return view('admin.dashboard', compact('clients', 'title', 'isMobile'));  
    }  

    // Logout Admin  
    public function logout()  
    {  
        Auth::guard('admin')->logout(); // Logout admin  
        return redirect()->route('admin.login'); // Redirect ke halaman login admin  
    }



    public function viewAllCarts(Request $request)  
    {  
        // Ambil semua client beserta data keranjangnya  
        $query = Client::with('carts.product');  
    
        // Cek apakah ada input pencarian  
        if ($request->has('search')) {  
            $search = $request->input('search');  
            $query->where(function($q) use ($search) {  
                $q->where('username', 'like', "%{$search}%")  
                  ->orWhere('email', 'like', "%{$search}%");
            });  
        }  
    
        $clients = $query->get();  
        $title = "Keranjang Client";  
        $agent = new \Jenssegers\Agent\Agent();  
        $isMobile = $agent->isMobile();  
        return view('admin.carts.index', compact('clients', 'title', 'isMobile'));  
    }

    // Tampilkan keranjang milik 1 client berdasarkan ID  
    public function viewClientCart($clientId)  
    {  
        // Cari data client berdasarkan ID, dan ambil data keranjangnya  
        $client = Client::with('carts.product')->findOrFail($clientId);  
        $title = "Detail Keranjang";
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        return view('admin.carts.show', compact('client', 'title', 'isMobile'));  
    }  
    
    public function viewClientProfile($clientId)  
    {  
        // Cari data client berdasarkan ID, dan ambil data keranjangnya  
        $client = Client::with('carts.product')->findOrFail($clientId);  
        $title = "Detail Profil";
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        return view('admin.carts.index', compact('client', 'title', 'isMobile'));  
    }  
    
    
    public function clientOrders(Client $client)
    {
        $orders = $client->orders()->latest()->get();
        return view('admin.carts.orders', compact('client', 'orders'));
    }

    // public function clientOrderDetails(Client $client)
    // {
    //     $orders = $client->orders()->with('items.product')->latest()->get();

    //     $profitSummary = $orders->map(function ($order) {
    //         $profit = $order->items->sum(function ($item) {
    //             return ($item->product->selling_price - $item->product->cost_price) * $item->quantity;
    //         });

    //         return [
    //             'order_id' => $order->order_id,
    //             'total_profit' => $profit,
    //             'created_at' => $order->created_at,
    //         ];
    //     });

    //     return view('admin.carts.detailorder', compact('client', 'orders', 'profitSummary'));
    // }

}