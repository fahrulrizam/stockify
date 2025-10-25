@extends('layouts.app')

@section('title', 'Dashboard Kategori')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-extrabold text-pink-600 flex items-center justify-center md:justify-start gap-3 mb-6">
    <div class="flex items-center justify-center bg-gradient-to-br from-pink-500 to-fuchsia-500 text-white w-14 h-14 rounded-2xl shadow-lg">
        <i class="fas fa-tags text-2xl"></i>
    </div>
    <span>Dashboard Kategori</span>
</h1>

                <p class="text-gray-600 text-sm md:text-base">Kelola dan pantau semua kategori produk dengan mudah</p>
            </div>

            <a href="{{ route('admin.categories.create') }}" 
   class="mt-4 md:mt-0 inline-flex items-center bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white px-6 py-3 rounded-xl shadow-md hover:from-fuchsia-600 hover:to-pink-600 transform hover:scale-105 transition">
    ➕ Tambah Kategori
</a>

        </div>

        {{-- ================= STATISTIK ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            {{-- Total Kategori --}}
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Total Kategori</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Category::count() }}</p>
            </div>

            {{-- Kategori Ditampilkan --}}
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-2xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Kategori Ditampilkan</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ $categories->total() }}</p>
            </div>

            {{-- Total Produk --}}
            <div class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-2xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Total Produk</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Product::count() }}</p>
            </div>

            {{-- Rata-rata Produk per Kategori --}}
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white rounded-2xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Rata-rata Produk/Kategori</h3>
                @php
                    $categoryCount = \App\Models\Category::count() ?: 1;
                    $productCount = \App\Models\Product::count();
                @endphp
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ round($productCount / $categoryCount, 1) }}</p>
            </div>
        </div>

        {{-- ================= TABEL KATEGORI ================= --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-md">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white">
                    <tr>
                        <th class="px-5 py-3 text-center font-semibold">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Nama Kategori</th>
                        <th class="px-5 py-3 text-center font-semibold">Jumlah Produk</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($categories as $index => $category)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-5 py-3 text-center">{{ $categories->firstItem() + $index }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                            <td class="px-5 py-3 text-center">{{ $category->products()->count() }}</td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg shadow font-semibold transition transform hover:scale-105">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg shadow font-semibold transition transform hover:scale-105">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-6 italic">
                                <i class="fas fa-info-circle mr-1"></i> Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if ($categories->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $categories->links('pagination::tailwind') }}
            </div>
        @endif

        {{-- ================= TOMBOL KEMBALI ================= --}}
        <div class="text-center mt-10">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
