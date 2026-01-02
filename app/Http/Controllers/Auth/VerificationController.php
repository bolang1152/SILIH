<?php
// app/Http/Controllers/Auth/VerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    // Menampilkan halaman notifikasi verifikasi email
    public function show()
    {
        return view('auth.verify');
    }

    // Mengirim ulang email verifikasi
    public function resend(Request $request)
    {
        return back()->with('resent', true);
    }
}

