<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    $user = $request->user();

    // Bypass sementara untuk manager selama pengembangan
    if ($user && $user->role === 'manager') {
        return $next($request);
    }

    if ($user && in_array($user->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Akses ditolak.');
}

}
