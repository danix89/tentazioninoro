<?php

namespace Tentazioninoro\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Debugbar;

class RedirectIfAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
	if (Auth::guard($guard)->check()) {
	    $user = Auth::user();
	    
	    if ($user->permissions === \Config::get('constants.permission.FIXINGS')) {
		Debugbar::info(\Config::get('constants.permission.FIXINGS'));
	    } else if ($user->permissions === \Config::get('constants.permission.SALES_ACTS')) {
		Debugbar::info(\Config::get('constants.permission.SALES_ACTS'));
	    }
	} else {
	    return $next($request);
	}
    }

}
