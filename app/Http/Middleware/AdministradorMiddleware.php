<?php

namespace App\Http\Middleware;

use Closure, Auth;
use Illuminate\Http\Request;

class AdministradorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        if(!Auth::guard('administradores')->check()/* && !Auth::guard('empresa')->check()*/){
            return redirect('admin/login');
        }
        /*/
        elseif(Auth::guard('empresa')->check()){
            return redirect()->route('/unauthorized');
        }
        /*/
        else{
            return $next($request);
        }
        
    }
}
