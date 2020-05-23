<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    
    public function handle($request, Closure $next=null , $guard='admin')
    {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }else{
            return redirect('admin/login');
        }
        
    }
}
