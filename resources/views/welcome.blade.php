<!DOCTYPE html>

<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Stockify | Aplikasi Manajemen Stok Barang Modern</title>
<!-- Asumsi Tailwind CSS sudah dikompilasi atau di-link di sini -->
<link href="https://www.google.com/search?q=https://cdn.jsdelivr.net/npm/tailwindcss%402.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- Font Inter -->
<style>
body { font-family: 'Inter', sans-serif; }
</style>
</head>
<body class="bg-gray-50 antialiased">

<header class="p-4 bg-white border-b border-gray-100 shadow-sm">
<div class="max-w-7xl mx-auto flex justify-between items-center">
<a href="/" class="text-2xl font-extrabold text-indigo-700 tracking-wider">Stockify</a>
<nav class="space-x-4">
@auth
<a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-indigo-700 font-medium">Dashboard</a>
@else
<a href="{{ route('login') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg font-semibold shadow-md transition duration-150">Masuk</a>
@if (Route::has('register'))
<a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 px-4 py-2 rounded-lg font-semibold transition duration-150 hidden sm:inline-block">Daftar</a>
@endif
@endauth
</nav>
</div>
</header>

<main>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
<!-- Hero Section -->
<div class="bg-white p-8 sm:p-12 rounded-3xl shadow-2xl">
<h1 class="text-5xl sm:text-7xl font-extrabold tracking-tight text-gray-900 leading-tight">
Kelola Stok Anda dengan Cepat dan Akurat
</h1>
<p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
Stockify adalah solusi manajemen stok barang berbasis web yang dirancang untuk meningkatkan akurasi data dan mempermudah setiap transaksi gudang.
</p>
<div class="mt-10 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
@auth
<a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-lg font-extrabold text-white bg-green-500 rounded-xl hover:bg-green-600 transition duration-150 shadow-lg">
Lihat Dashboard Anda
</a>
@else
<a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-lg font-extrabold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition duration-150 shadow-lg shadow-indigo-500/50">
Mulai Sekarang
</a>
<a href="#" class="w-full sm:w-auto px-8 py-4 text-lg font-extrabold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition duration-150">
Pelajari Fitur
</a>
@endauth
</div>
</div>

    <!-- Features Overview Section -->
    <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-indigo-500">
            <div class="text-4xl text-indigo-600 mb-4">📈</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pemantauan Real-Time</h3>
            <p class="text-gray-500">Lihat stok yang tersedia, stok minimum, dan pergerakan barang secara instan, kapan saja.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-green-500">
            <div class="text-4xl text-green-600 mb-4">📦</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Manajemen Transaksi Mudah</h3>
            <p class="text-gray-500">Cepat catat barang masuk, barang keluar, dan lakukan *stock opname* tanpa repot.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border-t-4 border-yellow-500">
            <div class="text-4xl text-yellow-600 mb-4">👥</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Kontrol Akses Berperan</h3>
            <p class="text-gray-500">Atur hak akses untuk Admin, Manajer Gudang, dan Staff Gudang secara terpisah.</p>
        </div>
    </div>
</div>

</main>

<footer class="mt-20 border-t border-gray-200 bg-gray-100 p-8">
<p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} Stockify. All rights reserved.</p>
</footer>

</body>
</html>