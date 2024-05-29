<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isUserMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->user_roles == 'user'){
            return $next($request);
        }else{
            // return redirect()->route('login');
            return redirect()->route('login')->with("message", "You dont have permission to access this page");
        }
    }
}
