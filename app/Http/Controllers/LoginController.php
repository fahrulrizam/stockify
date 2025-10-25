<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showManagerLoginForm()
    {
        return view('auth.manager-login');
    }

    public function managerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Tambahkan cek role manajer
        if (Auth::attempt(array_merge($credentials, ['role' => 'manajer']))) {
            $request->session()->regenerate();
            return redirect()->intended(route('manager.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah / bukan manajer.',
        ])->onlyInput('email');
    }
}
