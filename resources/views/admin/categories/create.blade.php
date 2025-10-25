@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-12 px-4">
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-pink-500 to-fuchsia-600 shadow-lg text-white text-3xl mb-4">
    <i class="fas fa-tags text-2xl"></i>
</div>
<h1 class="text-3xl md:text-4xl font-extrabold text-pink-700">Tambah Kategori</h1>

            <p class="text-gray-500 mt-1 text-sm md:text-base">Buat kategori baru untuk mengelompokkan produk Anda.</p>
        </div>

        {{-- ================= FORM ================= --}}
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- NAMA KATEGORI --}}
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama kategori"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm text-gray-800 
                           focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200"
                    required
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= BUTTONS ================= --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95 gap-2">
                    ⬅️ <span>Kembali</span>
                </a>

                <button type="submit" 
                        class="inline-flex items-center bg-gradient-to-r from-pink-500 to-fuchsia-600 hover:from-pink-600 hover:to-fuchsia-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95 gap-2">

                    💾 <span>Simpan</span>

                </button>
            </div>
        </form>

    </div>
</div>
@endsection
