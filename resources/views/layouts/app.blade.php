<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SILIH - Sistem Informasi Peminjaman</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite([
        'resources/sass/app.scss',
        'resources/css/app.css',
        'resources/css/custom.css',
        'resources/css/components.css',
        'resources/css/plugins.css',
        'resources/js/app.js',
        'resources/js/custom.js',
        'resources/js/components.js',
        'resources/js/pages.js',
        'resources/js/utils.js'
    ])
</head>
<body>
    <div id="app">
        <!-- Navbar SILIH -->
        <nav class="navbar-silih">
            <div class="container">
                <a class="navbar-brand-silih" href="{{ url('/') }}">
                    <div class="navbar-logo">
                        <svg width="28" height="28" viewBox="0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="navbar-title">SILIH</span>
                </a>

                <button class="navbar-toggle-silih" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="collapse navbar-collapse-silih" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav-silih me-auto">
                        @auth
                            <li class="nav-item-silih">
                                <a class="nav-link-silih {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item-silih">
                                <a class="nav-link-silih {{ request()->routeIs('items.*') ? 'active' : '' }}" href="{{ route('items.index') }}">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Items
                                </a>
                            </li>
                            <li class="nav-item-silih">
                                <a class="nav-link-silih {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Rooms
                                </a>
                            </li>
                            <li class="nav-item-silih">
                                <a class="nav-link-silih {{ request()->routeIs('room_bookings.*') ? 'active' : '' }}" href="{{ route('room_bookings.index') }}">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Room Bookings
                                </a>
                            </li>
                            <li class="nav-item-silih">
                                <a class="nav-link-silih {{ request()->routeIs('item_borrowings.*') ? 'active' : '' }}" href="{{ route('item_borrowings.index') }}">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Item Borrowings
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav-silih ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item-silih">
                                    <a class="nav-link-silih" href="{{ route('login') }}">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item-silih">
                                    <a class="nav-link-silih nav-link-register" href="{{ route('register') }}">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Daftar
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item-silih dropdown">
                                <a id="navbarDropdown" class="nav-link-silih nav-link-user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="user-avatar">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu-silih">
                                    <a class="dropdown-item-silih" href="{{ route('profile') }}">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a class="dropdown-item-silih" href="{{ route('profile.edit') }}">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit Profil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item-silih logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content-silih">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer-silih">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <svg width="24" height="24" viewBox="0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <span class="footer-title">SILIH</span>
                    </div>
                    <div class="footer-text">
                        &copy; {{ date('Y') }} Sistem Informasi Peminjaman. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

