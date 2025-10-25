<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stockify - Sistem Manajemen Stok')</title>

    {{-- Tailwind + Font Awesome --}}
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Bootstrap (untuk komponen tertentu seperti modal) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 min-h-screen flex flex-col">

@php
    $setting = \App\Models\Setting::first();
@endphp

{{-- ======================================= --}}
{{-- HEADER UTAMA --}}
{{-- ======================================= --}}
<header class="bg-white shadow-md py-4 px-8 flex items-center justify-between sticky top-0 z-50">
    <div class="flex items-center space-x-4">
        <img src="{{ asset('storage/logos/logo.jpg') }}" alt="Logo"
             class="w-14 h-14 rounded-full border border-gray-200 object-cover">
        <h1 class="text-2xl font-extrabold text-gray-800">
            {{ $setting->app_name ?? 'Stockify' }}
        </h1>
    </div>

    {{-- User --}}
    <div class="flex items-center space-x-4">
        <div class="text-right">
            <p class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
            <p class="text-sm text-gray-600">{{ ucfirst(Auth::user()->role ?? 'administrator') }}</p>
        </div>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
             class="w-12 h-12 rounded-full border-2 border-indigo-500 shadow-md object-cover">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-4 py-2 rounded-xl hover:scale-105 transition">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</header>

{{-- ======================================= --}}
{{-- SIDEBAR + MAIN CONTENT --}}
{{-- ======================================= --}}
<div class="flex flex-1">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-xl border-r hidden lg:block">
        <nav class="flex flex-col p-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link">
                <i class="fas fa-box"></i> Produk
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="nav-link">
                <i class="fas fa-truck"></i> Supplier
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link">
                <i class="fas fa-file-invoice"></i> Transaksi
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-link">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </nav>
    </aside>

    {{-- Konten Utama --}}
    <main class="flex-1 p-8 bg-gradient-to-br from-indigo-50 via-sky-50 to-fuchsia-50">
        @yield('content')
    </main>
</div>

{{-- Footer --}}
<footer class="bg-white text-center py-3 text-gray-600 border-t text-sm">
    © {{ date('Y') }} <strong>Stockify</strong> — Sistem Manajemen Stok & Gudang Modern.
</footer>

{{-- Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
.nav-link {
    @apply flex items-center gap-3 px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition;
}
</style>
</body>
</html>
