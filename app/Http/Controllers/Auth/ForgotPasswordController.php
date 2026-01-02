<?php

// app/Http/Controllers/Auth/ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // Menampilkan form untuk mengirim email reset password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Mengirimkan email untuk reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
