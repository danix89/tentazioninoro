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
//	    $user = Auth::user();
	    Debugbar::info("Autenticato");
	    return redirect(route('home'));
	} else {
	    Debugbar::info("Non autenticato");
	}
	
	return $next($request);
    }

}
