<?php

namespace App\Http\Middleware;  

use Closure;  
use Illuminate\Support\Facades\Auth;  

class RedirectIfNotAuthenticated  
{  
    public function handle($request, Closure $next, $guard = 'admin')  
    {  
        if (!Auth::guard($guard)->check()) {  
            // Redirect to login page with a message  
            return redirect()->route('admin.login')->with('error', 'Anda harus login terlebih dahulu');  
        }  

        return $next($request);  
    }  
}