<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan pengguna terautentikasi dan memiliki peran (role)
        if (!Auth::check() || !Auth::user()->role) {
            return redirect('/login')->with('error', 'Akses ditolak. Silakan login.');
        }

        // Ambil ID peran pengguna yang login
        $userRoleId = Auth::user()->role_id;
        
        // Cek apakah ID peran pengguna ada di daftar peran yang diizinkan ($roles)
        foreach ($roles as $role) {
            if ($userRoleId == $role) {
                return $next($request);
            }
        }

        // Jika peran tidak diizinkan, redirect ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
    }
}