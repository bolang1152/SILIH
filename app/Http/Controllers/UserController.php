<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan profil pengguna
    public function showProfile()
    {
        // Pastikan pengguna sudah memverifikasi email
        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('profile', compact('user'));
    }

    // Menampilkan form untuk mengedit profil pengguna
    public function editProfile()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('edit-profile', compact('user')); // Tampilkan form untuk edit profil
    }

    // Mengupdate data pengguna
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login

        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Perbarui data pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
