<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            Auth::user()->update([
                'active' => true
            ]);

            return $this->redirectRole();
        }

        return back()->with('loginError', 'Email atau password salah.');
    }

    protected function redirectRole()
    {

        $namaRole = Auth::user()->RelasiRoles->name;

        if ($namaRole === 'admin') {
            return redirect()->route('home');
        } elseif ($namaRole === 'kepala upt') {
            return redirect()->route('home_kepala_upt');
        } elseif ($namaRole === 'jaringan') {
            return redirect()->route('home_jaringan');
        } elseif ($namaRole === 'koordinator') {
            return redirect()->route('home_koordinator');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request){

        if (Auth::check()) {
            Auth::user()->update([
                'active' => false
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
