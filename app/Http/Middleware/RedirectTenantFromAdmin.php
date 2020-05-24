<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;

class RedirectTenantFromAdmin
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
        try {
            $tenant = tenant();
            return redirect()->route('home');
        } catch (BindingResolutionException $e) {}

        return $next($request);
    }
}
