<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::get('alpha_id'))
        {
            return $next($request);  
        }
        else
        {
            return redirect('/siteadmin');
        }
        
    }
}
