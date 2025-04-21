<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika pengguna sudah login (session 'role' dan 'user' ada)
        if (session('role') && session('user')) {
            // Cek apakah pengguna sedang mencoba mengakses halaman login
            if ($request->routeIs('auth.login.types')) {
                return redirect()->route('dashboard.home'); // Arahkan ke dashboard atau halaman utama
            }

            return $next($request); // Lanjutkan jika bukan halaman login
        }

        // Jika pengguna belum login, arahkan ke halaman login
        if (!$request->routeIs('auth.login.types')) {
            return redirect()->route('auth.login.types')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        return $next($request);
    }
}
