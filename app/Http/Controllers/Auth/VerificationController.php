<?php
// app/Http/Controllers/Auth/VerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    // Menampilkan halaman notifikasi verifikasi email
    public function show()
    {
        // Jika pengguna sudah terverifikasi, arahkan ke profil
        if (Auth::users()->hasVerifiedEmail()) {
            return redirect()->route('profile');
        }

        return view('auth.verify');
    }

    // Menangani verifikasi email
    public function verify(Request $request)
    {
        $user = Auth::user();

        // Pastikan email sudah terverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile');
        }

        // Verifikasi ID dan email dengan hash
        if ($request->route('id') == $user->id && hash_equals((string) $request->route('hash'), sha1($user->email))) {
            // Tandai email sebagai sudah terverifikasi
            $user->markEmailAsVerified();

            // Trigger event setelah email terverifikasi
            event(new Verified($user));

            // Redirect ke profil setelah verifikasi berhasil
            return redirect()->route('profile')->with('verified', true);
        }

        return redirect()->route('login');
    }

    // Mengirim ulang email verifikasi
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
