<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Jika request BUKAN request API (expectsJson), arahkan ke halaman login
        if (! $request->expectsJson()) {
            return route('login');
        }
        
        // Untuk request API, return null (yang akan menghasilkan response 401 Unauthorized)
        return null; 
    }
}