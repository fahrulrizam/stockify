<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stockify - Sistem Manajemen Stok')</title>

    {{-- TailwindCSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom Styles --}}
    <style>
        /* ================= Glassmorphism ================= */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .glass:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        /* ================= Badge Notifikasi ================= */
        .nav-link span {
            font-size: 0.65rem;
            z-index: 10;
        }

        /* ================= Animasi Partikel ================= */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes bounce-slower {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-slow { animation: bounce-slow 4s infinite ease-in-out; }
        .animate-bounce-slower { animation: bounce-slower 6s infinite ease-in-out; }
        .animate-pulse-slow { animation: pulse 6s infinite; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-gradient-to-br from-indigo-100 via-sky-50 to-fuchsia-100 relative overflow-x-hidden">

@php
    $setting = \App\Models\Setting::first();
    $produkNotif = \App\Models\Product::where('status','new')->count();
    $transNotif  = \App\Models\Transaction::where('status','pending')->count();
@endphp

{{-- ================= HEADER ================= --}}
<header class="w-full bg-white/70 backdrop-blur-3xl shadow-lg border-b border-white/30 py-4 px-8 flex items-center justify-between sticky top-0 z-50 transition-all duration-300">
    {{-- Logo & App Name --}}
    <div class="flex items-center space-x-4">
        <img src="{{ asset('storage/logos/logo.jpg') }}" alt="Logo"
             class="w-16 h-16 rounded-full border-2 border-indigo-400 shadow-lg object-cover bg-white/70 transition-transform hover:scale-110">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm">
            {{ $setting->app_name ?? 'STOCKIFY' }}
        </h1>
    </div>

    {{-- Brand Highlight --}}
    <div class="flex items-center space-x-4">
        <div class="p-2 bg-gradient-to-tr from-indigo-500 to-blue-500 text-white rounded-full shadow-lg animate-pulse hover:scale-110 transition-transform">
            <i class="fas fa-warehouse text-xl md:text-2xl"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-blue-500 to-fuchsia-600 drop-shadow-lg tracking-tight transform transition-all hover:scale-105 hover:rotate-1">
            STOCKIFY
        </h1>
    </div>

    {{-- User Info --}}
    <div class="flex items-center space-x-4">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
             class="w-12 h-12 rounded-full border-2 border-indigo-400 shadow-lg object-cover bg-white/70 transition-transform hover:scale-110">
        <div class="text-right">
            <p class="font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
            <p class="text-sm text-white/90 px-3 py-1 bg-indigo-500 rounded-full shadow-md uppercase animate-pulse">
                {{ ucfirst(Auth::user()->role ?? 'Administrator') }}
            </p>
        </div>
    </div>
</header>

{{-- ================= SIDEBAR ================= --}}
<aside class="w-64 bg-white/60 backdrop-blur-3xl shadow-lg border-r border-white/20 fixed top-0 left-0 h-full z-50 overflow-y-auto transition-all duration-300 hover:backdrop-blur-[40px]">
    <div class="p-6">
        {{-- Sidebar Logo --}}
       <div class="flex items-center space-x-4">
    {{-- Ikon Gudang --}}
    <div class="bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4 rounded-full shadow-lg
                animate-pulse hover:scale-110 transition-transform duration-300">
        <i class="fas fa-warehouse text-2xl"></i>
    </div>

    {{-- Nama Aplikasi --}}
    <h1 class="text-4xl font-extrabold tracking-tight
               text-transparent bg-clip-text
               bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500
               drop-shadow-sm">
        Stockify
    </h1>
</div>

        {{-- Navigasi Sidebar --}}
        <nav class="flex flex-col space-y-3">
            <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-home"></i> Dashboard
            </a>

            <a href="{{ route('manajer.products.index') }}" class="nav-link relative flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-box"></i> Produk
                @if($produkNotif > 0)
                    <span class="absolute top-1 right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                        +{{ $produkNotif }}
                    </span>
                @endif
            </a>

            <a href="{{ route('categories.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-tags"></i> Kategori
            </a>

            <a href="{{ route('suppliers.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-truck"></i> Supplier
            </a>

            <a href="{{ route('transactions.index') }}" class="nav-link relative flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-file-invoice"></i> Transaksi
                @if($transNotif > 0)
                    <span class="absolute top-1 right-3 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                        +{{ $transNotif }}
                    </span>
                @endif
            </a>

            <a href="{{ route('reports.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-chart-line"></i> Laporan
            </a>

            <a href="{{ route('settings.index') }}" class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-100 transition">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </nav>
    </div>
</aside>

{{-- ================= KONTEN UTAMA ================= --}}
<main class="flex-1 ml-64 p-10 relative overflow-hidden">
    {{-- Background Partikel --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="w-full h-full bg-gradient-to-br from-indigo-50 via-sky-50 to-fuchsia-50 animate-pulse-slow"></div>
        <div class="absolute w-2 h-2 bg-indigo-400 rounded-full animate-bounce-slow top-10 left-20 opacity-70"></div>
        <div class="absolute w-3 h-3 bg-fuchsia-400 rounded-full animate-bounce-slow top-40 left-60 opacity-60"></div>
        <div class="absolute w-2 h-2 bg-sky-400 rounded-full animate-bounce-slow top-80 left-40 opacity-50"></div>
        <div class="absolute w-1 h-1 bg-yellow-400 rounded-full animate-bounce-slower top-20 left-80 opacity-50"></div>
        <div class="absolute w-2 h-2 bg-pink-400 rounded-full animate-bounce-slower top-60 left-10 opacity-60"></div>
    </div>

    {{-- Konten Blade --}}
    <div class="relative z-10 max-w-7xl mx-auto glass p-10 border border-white/30 hover:shadow-purple-400/30 transition-all duration-300 hover:scale-[1.01]">
        @yield('content')
    </div>
</main>

{{-- ================= FOOTER ================= --}}
<footer class="w-full bg-gradient-to-r from-indigo-100 via-purple-50 to-fuchsia-100 text-center py-3 text-gray-700 text-sm font-medium shadow-inner mt-6 rounded-t-3xl">
    © {{ date('Y') }} <strong>Stockify</strong> — Sistem Manajemen Stok & Gudang Modern.
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
