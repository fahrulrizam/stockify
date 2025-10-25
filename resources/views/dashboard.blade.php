@extends('layouts.app')

@section('title', 'Dashboard - Stockify')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">📦 Dashboard Produk</h1>
        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           + Tambah Produk
        </a>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Total Produk</h2>
            <p class="text-3xl font-semibold text-gray-800">{{ $products->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Stok Tersedia</h2>
            <p class="text-3xl font-semibold text-green-600">
                {{ $products->sum('stok') }}
            </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Nilai Total Barang</h2>
            <p class="text-3xl font-semibold text-indigo-600">
                Rp {{ number_format($products->sum(fn($p) => $p->harga * $p->stok), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama Produk</th>
                    <th class="px-6 py-3 text-left font-semibold">Kategori</th>
                    <th class="px-6 py-3 text-left font-semibold">Stok</th>
                    <th class="px-6 py-3 text-left font-semibold">Harga</th>
                    <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $product->nama }}</td>
                        <td class="px-6 py-3">{{ $product->kategori }}</td>
                        <td class="px-6 py-3">{{ $product->stok }}</td>
                        <td class="px-6 py-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
