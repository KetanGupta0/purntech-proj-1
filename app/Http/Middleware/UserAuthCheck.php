<?php

namespace App\Http\Middleware;

use App\Models\WebUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('loggedin')){
            if(Session::get('loggedin') != 'user'){
                return redirect('/admin-dashboard');
            }
            $user = WebUser::where('usr_id', Session::get('uid'))->first();
                if($user && $user->usr_profile_status == 1){
                    
                }else{
                    return redirect('logout');
                }
        }else{
            return redirect('/');
        }
        return $next($request);
    }
}
