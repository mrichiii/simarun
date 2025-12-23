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
            return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('dashboard');
        }

        $type = request()->query('type', 'nim');
        return view('auth.login', compact('type'));
    }

    public function login(Request $request)
    {
        // Support explicit form type: 'nim' (mahasiswa without password) or 'email' (email+password)
        $type = $request->input('type');

        if ($type === 'nim') {
            $request->validate([
                'login' => 'required|numeric|max_digits:10',
            ]);

            $input = $request->input('login');
            $user = User::where('nim', $input)->first();

            if ($user && $user->role === 'user') {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }

            return back()->withErrors([
                'login' => 'NIM tidak terdaftar atau tidak memiliki akses mahasiswa',
            ])->onlyInput('login');
        }

        // Default: email + password login (admin or other users)
        $request->validate([
            'login' => 'required|email',
            'password' => 'required|string'
        ]);

        $input = $request->input('login');

        if (Auth::attempt(['email' => $input, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            return $user->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login' => 'Email atau password salah',
        ])->onlyInput('login');
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

        return view('admin.admin', compact('totalRuangan', 'ruanganTersedia', 'ruanganTerpakai', 'ruanganTidakDapatDipakai', 'allRuangan'));
    }
}


