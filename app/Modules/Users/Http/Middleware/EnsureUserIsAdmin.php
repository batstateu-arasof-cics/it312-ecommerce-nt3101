<?php

namespace App\Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Used by every admin route as ->middleware(['auth', 'admin']).
 * Registered as the 'admin' alias in bootstrap/app.php.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            abort(403, 'Admins only.');
        }

        return $next($request);
    }
}
