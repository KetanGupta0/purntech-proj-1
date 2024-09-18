<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoggedUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('loggedin')){
            if(Session::get('loggedin') == 'admin'){
                return redirect('admin-dashboard');
            }elseif(Session::get('loggedin') == 'user'){
                return redirect('user-dashboard');
            }
        }
        // Session::flush();
        // Session::forget('loggedin');
        return $next($request);
    }
}
