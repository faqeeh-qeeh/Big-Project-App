<?php

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use App\Models\Client;  
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Validator; 
use Jenssegers\Agent\Agent; 

class ClientController extends Controller  
{  

    public function showRegisterForm()  
    {  
        return view('client.register');  
    }  

    public function register(Request $request)  
    {  
        $validator = Validator::make($request->all(), [  
            'full_name' => ['required', 'string', 'max:255'],  
            'username' => ['required', 'string', 'max:255', 'unique:clients'],  
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],  
            'birth_date' => ['required', 'date'],  
            'gender' => ['required', 'in:male,female'],
            'phone' => ['required', 'string', 'max:15'],   
            'address' => ['required', 'string'],  
            'password' => ['required', 'string', 'min:8', 'confirmed'],  
        ]);  
    
        if ($validator->fails()) {  
            return back()->withErrors($validator)->withInput();  
        }  
        try {  
            Client::create([  
                'full_name' => $request->full_name,  
                'username' => $request->username,  
                'email' => $request->email,  
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,  
                'phone' => $request->phone,   
                'address' => $request->address,  
                'password' => Hash::make($request->password),  
            ]);  
            return redirect()->route('client.login')->with('success', 'Selamat, akun ' . $request->username . ' anda sudah terdaftar. Silakan login.');
            // return redirect()->route('client.login')->with('success', 'Client registered successfully. Please login.');  
        } catch (\Exception $e) {  
            return back()->withErrors(['registration' => 'Failed to register the client. Please try again later.'])->withInput();  
        }  
    }

    public function showLoginForm()  
    {  
        $success = session('success');
        // return view('client.login');  
        return view('client.login', compact('success'));  
    }  

    public function login(Request $request)  
    {   
        $request->validate([  
            'username' => 'required|string',  
            'password' => 'required|string',  
        ]);  

        $client = Client::where('username', $request->username)->first();  

        if (!$client) {  
            return back()->withErrors(['username' => 'Username tidak ditemukan'])->withInput();  
        }  

        if (Auth::guard('client')->attempt(['username' => $request->username, 'password' => $request->password])) {  
            return redirect()->route('kanjeng.mami');  
        }  
 
        return back()->withErrors(['password' => 'password salah'])->withInput();  
    }

    // Show Client Dashboard (or redirect after login)  
    public function dashboard()  
    {   
        
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        $client = Auth::guard('client')->user();  
        return view('client.dashboard', compact('client', 'isMobile'));  
    }  

    // Logout Client  
    public function logout()  
    {  
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
        Auth::guard('client')->logout(); // Logout client  
        return redirect()->route('client.login'); // Redirect ke halaman login client  
    }


    public function editProfile()  
    {  
        $client = Auth::guard('client')->user();  
        return view('client.edit-profile', compact('client'));  
    }  
    
    public function updateProfile(Request $request)  
    {  
        $client = Auth::guard('client')->user();  
    
        $validator = Validator::make($request->all(), [  
            'full_name' => ['required', 'string', 'max:255'],  
            'birth_date' => ['required', 'date'],  
            'gender' => ['required', 'in:male,female'],  
            'phone' => ['required', 'string', 'max:15'],  
            'address' => ['required', 'string'],  
        ]);  
    
        if ($validator->fails()) {  
            return back()->withErrors($validator)->withInput();  
        }  
    
        try {  
            $client->update([  
                'full_name' => $request->full_name,  
                'birth_date' => $request->birth_date,  
                'gender' => $request->gender,  
                'phone' => $request->phone,  
                'address' => $request->address,  
            ]);  
        
            return redirect()->route('client.profil')  
                ->with('success', 'Profil berhasil diperbarui');  
        } catch (\Exception $e) {  
            return back()->withErrors(['update' => 'Gagal memperbarui profil'])->withInput();  
        }  
    }

    protected function authenticated(Request $request, $user)  
{  
    return redirect()->route('client.profil'); // Redirect to client dashboard after login  
}

}