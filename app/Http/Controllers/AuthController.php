<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login()
    {
        return view("login");
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors([
            'login' => 'Username atau Password Salah',
        ]);
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
