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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('profile', compact('user'));  // Menampilkan halaman profil
    }

    // Menampilkan form untuk mengedit profil pengguna
    public function editProfile()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login
        return view('edit-profile', compact('user'));  // Menampilkan form untuk edit profil
    }

    // Mengupdate data pengguna
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();  // Ambil data pengguna yang sedang login

        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user->id,  // Mengecualikan email pengguna yang sedang diedit
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
