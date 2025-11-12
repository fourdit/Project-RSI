<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZENERGY - Penghematan Energi Listrik')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="app-header">
            <div class="header-left">
                <img src="{{ asset('images/logo.png') }}" alt="ZENERGY" class="logo">
                <span class="brand-name">ZENERGY</span>
            </div>
            <div class="header-right">
                <div class="user-profile" onclick="window.location.href='{{ route('profile.show') }}'">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="profile-photo">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <div class="app-body">
            <!-- Sidebar -->
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-line-fill nav-icon"></i>
                        <span class="nav-text">Dashboard Visual</span>
                    </a>
                    <a href="{{ route('electricity-notes.index') }}" class="nav-item {{ request()->routeIs('electricity-notes.*') ? 'active' : '' }}">
                        <i class="bi bi-lightning-charge-fill nav-icon"></i>
                        <span class="nav-text">Catatan Listrik</span>
                    </a>
                    <a href="{{ route('badge') }}" class="nav-item {{ request()->routeIs('badge') ? 'active' : '' }}">
                        <i class="bi bi-award-fill nav-icon"></i>
                        <span class="nav-text">Badge</span>
                    </a>
                    <a href="{{ route('calculator') }}" class="nav-item {{ request()->routeIs('calculator') ? 'active' : '' }}">
                        <i class="bi bi-calculator-fill nav-icon"></i>
                        <span class="nav-text">Kalkulator Hemat Energi</span>
                    </a>
                    <a href="{{ route('education') }}" class="nav-item {{ request()->routeIs('education') ? 'active' : '' }}">
                        <i class="bi bi-book-fill nav-icon"></i>
                        <span class="nav-text">Edukasi</span>
                    </a>
                    <a href="{{ route('discussion') }}" class="nav-item {{ request()->routeIs('discussion') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots-fill nav-icon"></i>
                        <span class="nav-text">Diskusi</span>
                    </a>
                    <a href="{{ route('other-features') }}" class="nav-item {{ request()->routeIs('other-features') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3-gap-fill nav-icon"></i>
                        <span class="nav-text">Fitur Lain</span>
                    </a>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="nav-item nav-logout">
                            <i class="bi bi-box-arrow-right nav-icon"></i>
                            <span class="nav-text">Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>