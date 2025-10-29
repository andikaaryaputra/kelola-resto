<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ======= TAMPILAN FORM LOGIN =======
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ======= PROSES LOGIN =======
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah!',
            ])->withInput();
        }

        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'administrator') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'waiter') {
            return redirect()->route('waiter.dashboard');
        } elseif ($user->role === 'kasir') {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } else {
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Role tidak dikenali.']);
        }
    }

    // ======= LOGOUT =======
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ======= DATA USER LOGIN =======
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
