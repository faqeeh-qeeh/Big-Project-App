<?php  

namespace App\Http\Middleware;  

use Illuminate\Auth\Middleware\Authenticate as Middleware;  

class Authenticate extends Middleware  
{  
    protected function redirectTo($request)  
    {  
        // Jika request berasal dari "admin/*", redirect ke admin login  
        if ($request->is('admin/*')) {  
            return route('admin.login');   
        }  

        // Jika request berasal dari "client/*", redirect ke client login  
        if ($request->is('client/*')) {  
            return route('client.login');   
        }  

        // Redirect ke login umum jika ada  
        // return route('login');  
    }  
}