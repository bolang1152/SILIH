@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Logo & Title -->
        <div class="auth-header">
            <div class="auth-logo">
                <svg width="48" height="48" viewBox="0 24" fill="0 24 none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <h2 class="auth-title">SILIH</h2>
            <p class="auth-subtitle">Sistem Informasi Peminjaman</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group-silih">
                    <label for="email" class="form-label-silih">Email Address</label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </span>
                        <input id="email" type="email" class="form-control-silih @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                            placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <div class="form-text-silih error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group-silih">
                    <label for="password" class="form-label-silih">Password</label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input id="password" type="password" class="form-control-silih @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                    </div>
                    @error('password')
                        <div class="form-text-silih error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group-silih">
                    <div class="form-check-silih">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group-silih">
                    <button type="submit" class="btn-silih btn-silih-primary w-100">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login
                    </button>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="forgot-password-link">
                            Lupa password?
                        </a>
                    </div>
                @endif
            </form>

            <!-- Register Link -->
            <div class="auth-footer">
                <p>Belum punya akun? 
                    <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }
    
    .auth-card {
        width: 100%;
        max-width: 420px;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }
    
    .auth-header {
        text-align: center;
        padding: 2.5rem 2rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
    }
    
    .auth-logo {
        margin-bottom: 0.75rem;
    }
    
    .auth-logo svg {
        width: 56px;
        height: 56px;
    }
    
    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .auth-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        margin: 0;
    }
    
    .auth-body {
        padding: 2rem;
    }
    
    .auth-footer {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
        text-align: center;
        font-size: 0.875rem;
        color: var(--gray-600);
    }
    
    .auth-link {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }
    
    .auth-link:hover {
        text-decoration: underline;
    }
    
    .forgot-password-link {
        font-size: 0.875rem;
        color: var(--gray-500);
        text-decoration: none;
    }
    
    .forgot-password-link:hover {
        color: var(--primary-color);
    }
</style>
@endsection
