<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = session('role');

        if (!in_array($userRole, $roles)) {
            $redirectRoute = $userRole === 'siswa' ? 'siswa.dashboard' : 'dashboard.home';

            return redirect()->route($redirectRoute)
                ->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
