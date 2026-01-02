@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Logo & Title -->
        <div class="auth-header">
            <div class="auth-logo">
                <svg width="48" height="48" viewBox="0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <h2 class="auth-title">SILIH</h2>
            <p class="auth-subtitle">Daftar Akun Baru</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group-silih">
                    <label for="name" class="form-label-silih">Nama Lengkap <span class="required">*</span></label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input id="name" type="text" class="form-control-silih @error('name') is-invalid @enderror" 
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('name')
                        <div class="form-text-silih error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group-silih">
                    <label for="email" class="form-label-silih">Email Address <span class="required">*</span></label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </span>
                        <input id="email" type="email" class="form-control-silih @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" 
                            placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <div class="form-text-silih error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group-silih">
                    <label for="password" class="form-label-silih">Password <span class="required">*</span></label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input id="password" type="password" class="form-control-silih @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <div class="form-text-silih error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group-silih">
                    <label for="password-confirm" class="form-label-silih">Konfirmasi Password <span class="required">*</span></label>
                    <div class="input-group-silih">
                        <span class="input-group-text">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <input id="password-confirm" type="password" class="form-control-silih" 
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi password Anda">
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group-silih">
                    <button type="submit" class="btn-silih btn-silih-success w-100">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Daftar Sekarang
                    </button>
                </div>

                <!-- Login Link -->
                <div class="auth-footer">
                    <p>Sudah punya akun? 
                        <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
                    </p>
                </div>
            </form>
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
        background: linear-gradient(135deg, var(--success-color), #16a34a);
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
        color: var(--success-color);
        font-weight: 600;
        text-decoration: none;
    }
    
    .auth-link:hover {
        text-decoration: underline;
    }
    
    .required {
        color: var(--danger-color);
    }
</style>
@endsection
