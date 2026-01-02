<?php
// app/Http/Controllers/Auth/VerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class VerificationController extends Controller
{
    // Menampilkan halaman notifikasi verifikasi email
    public function show()
    {
        if (Auth::User()->hasVerifiedEmail()) {
            return redirect()->route('profile');
        }

        return view('auth.verify');
    }

    // Menangani verifikasi email
    public function verify(Request $request)
    {
        $user = Auth::user();

        // Cek apakah email sudah terverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile');
        }

        if ($request->route('id') == $user->getKey() && hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            $user->markEmailAsVerified();
            event(new Verified($user)); // Menyebarkan event bahwa pengguna sudah diverifikasi

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
