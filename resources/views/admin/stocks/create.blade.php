@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-50 to-purple-100 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-indigo-700 flex justify-center items-center gap-3">
                <div class="flex items-center justify-center bg-indigo-600 text-white w-14 h-14 rounded-2xl shadow-lg">
        <i class="fas fa-boxes text-2xl"></i>
    </div>
    Tambah Barang Masuk
            </h2>
            <p class="text-gray-500 mt-2 text-sm">Catat jumlah barang masuk untuk memperbarui stok gudang.</p>
        </div>

        {{-- ================= NOTIFIKASI ================= --}}
        @if(session('error') || $errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                Terjadi kesalahan saat memproses data. Silakan periksa input Anda.
            </div>
        @endif
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= FORM ================= --}}
        <form action="{{ route('admin.stocks.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilih Produk --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pilih Produk</label>
                <select name="product_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 transition"
                        required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stok saat ini: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah Masuk --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jumlah Masuk</label>
                <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" placeholder="Masukkan jumlah"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 transition"
                       required>
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Keterangan (Opsional)</label>
                <textarea name="notes" rows="4" placeholder="Contoh: tambahan stok, pembelian baru, retur supplier, dll"
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 transition">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('admin.stocks.index') }}" 
                   class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                     💾 <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
