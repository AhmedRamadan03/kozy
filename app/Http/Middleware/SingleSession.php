<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class SingleSession
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth('web')->check() && !request()->routeIs('admin.*')) {
            $user = auth()->user();

            // Check if the session token stored in the database matches the current session token
            if ($user->remember_token !== $request->session()->token()) {
                auth()->logout();
                alert()->error('', __('lang.you_have_been_logged_out'));
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
