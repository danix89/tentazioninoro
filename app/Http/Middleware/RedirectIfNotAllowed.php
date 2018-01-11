<?php

namespace Tentazioninoro\Http\Middleware;

use Auth;
use Closure;
use Debugbar;

class RedirectIfNotAllowed {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions) {
	$user = Auth::user();
	if (isset($user)) {
	    if (!preg_match("/$user->permissions/", $permissions)) {
		Debugbar::info("Accesso non consentito");
		return redirect(route('accessNotAllowed'));
            }
	}
	return $next($request);
    }

}
