<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ruangan;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect('/admin/dashboard') : redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return $user->role === 'admin' ? redirect('/admin/dashboard') : redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard.user');
    }

    public function adminDashboard()
    {
        $totalRuangan = Ruangan::count();
        $ruanganTersedia = Ruangan::where('status', 'tersedia')->count();
        $ruanganTerpakai = Ruangan::where('status', 'tidak_tersedia')->count();
        $ruanganTidakDapatDipakai = Ruangan::where('status', 'tidak_dapat_dipakai')->count();

        $allRuangan = Ruangan::with('lantai.gedung')->get();

        return view('dashboard.admin', compact('totalRuangan', 'ruanganTersedia', 'ruanganTerpakai', 'ruanganTidakDapatDipakai', 'allRuangan'));
    }
}


