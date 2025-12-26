<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Tampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profil user
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'nim' => 'nullable|string|max:20|unique:users,nim,' . $user->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|string',
        ];

        // Tambahkan validasi confirmed jika password diisi
        if ($request->filled('password')) {
            $rules['password'] .= '|confirmed';
            $rules['password_confirmation'] = 'required|string';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'nim.unique' => 'NIM sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password_confirmation.required' => 'Konfirmasi password harus diisi jika mengubah password',
        ]);

        // Update data profil
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['nim'])) {
            $user->nim = $validated['nim'];
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
}
