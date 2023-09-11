<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $roles = empty($roles) ? [null] : $roles;
        foreach ($roles as $role){
            if ($request->user()->hasAnyRole($role)) {
                return $next($request);
            }
        }
        return redirect()->route(Auth::user()->getRedirectRoute());
    }
}
