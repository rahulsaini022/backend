<?php

namespace App\Http\Middleware;

use Closure;

class Active
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
        if( auth()->user()->status == 0)
       {
         return redirect('/login')->with('error','Account Blocked');
       }
           
        return $next($request);
    }
    
}
