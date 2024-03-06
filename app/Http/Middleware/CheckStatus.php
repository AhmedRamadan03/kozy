<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckStatus
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
         // IF User Is Blocked
         if(auth()->user()->is_active == 0){
             auth::logout();
             $request->session()->invalidate();
             toast(__('lang.you_are_blocked'), 'error');
             return redirect()->route('login');
         }
         return $next($request);
     }

}
