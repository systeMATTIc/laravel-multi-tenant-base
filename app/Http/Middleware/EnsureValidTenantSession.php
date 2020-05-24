<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession as Middleware;

class EnsureValidTenantSession extends Middleware
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
            return parent::handle($request, $next);
        } catch (\Throwable $th) {
            abort(404);
        }
    }
}
