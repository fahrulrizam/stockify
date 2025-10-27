@extends('layouts.app')

@section('title', 'Manajemen Stok Barang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-50 to-purple-100 py-12 px-4">
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 pb-6 border-b border-gray-200 gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 
                            hover:from-indigo-600 hover:to-indigo-700 
                            p-4 rounded-2xl shadow-lg flex items-center 
                            justify-center text-white transition-transform hover:scale-105"
                     style="width:64px; height:64px;">
                    <i class="fas fa-boxes text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700">Manajemen Stok Barang</h1>
                    <p class="text-gray-500 text-sm">Pantau dan kelola ketersediaan produk di gudang dengan mudah.</p>
                </div>
            </div>

            <a href="{{ route('admin.stocks.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 
                      hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold px-6 py-3 
                      rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                <i class="fas fa-plus-circle"></i> Tambah Stok Baru
            </a>
        </div>

        {{-- ================= STATISTIK RINGKAS ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-2xl shadow-xl 
                        p-6 flex items-center justify-between hover:scale-[1.03] transition-transform duration-300">
                <div>
                    <h3 class="text-lg opacity-90 font-medium">Total Produk</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ \App\Models\Product::count() }}</p>
                </div>
                <i class="fas fa-box-open text-5xl opacity-30"></i>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl shadow-xl 
                        p-6 flex items-center justify-between hover:scale-[1.03] transition-transform duration-300">
                <div>
                    <h3 class="text-lg opacity-90 font-medium">Total Supplier</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ \App\Models\Supplier::count() }}</p>
                </div>
                <i class="fas fa-truck text-5xl opacity-30"></i>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-2xl shadow-xl 
                        p-6 flex items-center justify-between hover:scale-[1.03] transition-transform duration-300">
                <div>
                    <h3 class="text-lg opacity-90 font-medium">Stok Minimum</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</p>
                </div>
                <i class="fas fa-exclamation-circle text-5xl opacity-30"></i>
            </div>
        </div>

        {{-- ================= TABEL STOK ================= --}}
        <div class="bg-white/95 rounded-2xl shadow-lg border border-gray-200 p-6 mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-indigo-600"></i> Daftar Stok Barang
                </h2>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-100">
                <table class="min-w-full text-sm">
                    <thead class="bg-indigo-100 text-indigo-800 font-semibold uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama Produk</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Supplier</th>
                            <th class="px-4 py-3 text-center">Stok</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse ($products as $p)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
                                <td class="px-4 py-3">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->supplier->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-center font-semibold {{ $p->stock <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $p->stock }}
                                </td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.stocks.edit', $p->id) }}" 
                                       class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 
                                              text-white px-3 py-1.5 rounded-xl shadow-sm font-semibold transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.stocks.destroy', $p->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 
                                                       text-white px-3 py-1.5 rounded-xl shadow-sm font-semibold transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-6">Tidak ada data stok barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= GRAFIK TOP 5 PRODUK ================= --}}
        @php
            $stockData = $products->take(5)->map(fn($p) => ['name' => $p->name, 'stock' => $p->stock]);
        @endphp

        <div class="bg-white/95 rounded-2xl shadow-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 border-b border-gray-200 pb-3 flex items-center gap-2">
                <i class="fas fa-chart-bar text-indigo-600"></i> Top 5 Produk Berdasarkan Stok
            </h2>
            <canvas id="stockChart" class="w-full" height="120"></canvas>
        </div>

        {{-- ================= TOMBOL KEMBALI ================= --}}
        <div class="text-center mt-10">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 
                      rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
               <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

{{-- ================= SCRIPT CHART ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const stockData = @json($stockData);

    if (stockData.length) {
        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: stockData.map(p => p.name),
                datasets: [{
                    label: 'Jumlah Stok',
                    data: stockData.map(p => p.stock),
                    backgroundColor: 'rgba(99, 102, 241, 0.85)',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    }
</script>
@endsection
