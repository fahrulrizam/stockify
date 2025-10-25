@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl p-8 md:p-12 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 p-4 rounded-2xl text-white shadow-lg">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700">Detail Produk</h1>
                    <p class="text-gray-500 text-sm mt-1">Informasi lengkap produk yang terdaftar</p>
                </div>
            </div>

            <a href="{{ route('admin.products.index') }}" 
               class="mt-6 md:mt-0 bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
                ⬅️ Kembali
            </a>
        </div>

        {{-- ================= DETAIL PRODUK ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- GAMBAR PRODUK --}}
            <div>
                @if($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image))
                    <img src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="rounded-2xl w-full h-80 object-cover border border-gray-200 shadow-md">
                @else
                    <div class="w-full h-80 flex items-center justify-center bg-gray-100 rounded-2xl text-gray-400 border border-dashed border-gray-300">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            {{-- INFORMASI PRODUK --}}
            <div class="col-span-2 space-y-6">

                {{-- Nama Produk --}}
                <h2 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h2>

                {{-- Statistik Produk --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <p class="text-xs text-gray-500 font-semibold">Harga Beli</p>
                        <p class="text-green-600 font-bold mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <p class="text-xs text-gray-500 font-semibold">Harga Jual</p>
                        <p class="text-indigo-700 font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <p class="text-xs text-gray-500 font-semibold">Stok</p>
                        <p class="mt-1 font-bold {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $product->stock }} {{ $product->stock <= 5 ? '- Hampir Habis' : '' }}
                        </p>
                    </div>
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <p class="text-xs text-gray-500 font-semibold">Status</p>
                        <span class="{{ $product->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1 rounded-full text-xs font-semibold mt-1 inline-block">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>

                {{-- Kategori & Supplier --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 font-semibold">Kategori</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $product->category->name ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 font-semibold">Supplier</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $product->supplier->name ?? '-' }}</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500 font-semibold mb-2">Deskripsi</p>
                    <p class="text-gray-700 leading-relaxed {{ empty($product->description) ? 'italic text-gray-400' : '' }}">
                        {{ $product->description ?: 'Deskripsi belum tersedia.' }}
                    </p>
                </div>

                {{-- Tombol Edit --}}
                <div class="pt-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition duration-200">
                       <i class="fas fa-box text-white text-3xl"></i> Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
