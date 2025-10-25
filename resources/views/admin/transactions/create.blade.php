@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-50 to-purple-100 py-12 px-4">
    <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 pb-6 border-b border-gray-200 gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 
                            hover:from-indigo-600 hover:to-purple-700 
                            p-4 rounded-2xl shadow-lg flex items-center 
                            justify-center text-white transition-transform hover:scale-105"
                     style="width:64px; height:64px;">
                    <i class="fas fa-exchange-alt text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-purple-700">Tambah Transaksi</h1>
                    <p class="text-gray-500 text-sm">Catat transaksi barang masuk atau keluar untuk pembaruan stok.</p>
                </div>
            </div>
        </div>

        {{-- ================= ALERT ERROR ================= --}}
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-2xl shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- ================= FORM ================= --}}
        <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Produk --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pilih Produk</label>
                <select name="product_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition"
                        required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Transaksi --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jenis Transaksi</label>
                <select name="type"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition"
                        required>
                    <option value="masuk" {{ old('type') == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="keluar" {{ old('type') == 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                <input type="number" name="quantity" value="{{ old('quantity') }}" 
                       placeholder="Masukkan jumlah barang"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition" required>
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Keterangan</label>
                <textarea name="description" rows="3" 
                          placeholder="Contoh: barang rusak, retur, stok tambahan, dll"
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                                 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('admin.transactions.index') }}" 
                   class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white 
                          px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 
                               hover:from-purple-600 hover:to-indigo-700 text-white font-semibold 
                               px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                      💾 <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
