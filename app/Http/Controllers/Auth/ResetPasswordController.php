<?php

// app/Http/Controllers/Auth/ResetPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Menampilkan form reset password
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Proses reset password
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Password berhasil direset.')
                    : back()->withErrors(['email' => __($status)]);
    }
}
