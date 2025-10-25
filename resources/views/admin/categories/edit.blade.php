@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-12 px-4">
    <div class="max-w-md mx-auto bg-white shadow-xl rounded-3xl p-8 border border-gray-200">

        {{-- HEADER --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 shadow-lg text-white text-3xl mb-4">
                 <i class="fas fa-tags text-2xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600">
    Edit Kategori
</h1>


            <p class="text-gray-500 mt-1 text-sm md:text-base">Perbarui data kategori produk dengan mudah dan cepat.</p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Kategori --}}
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" 
                       placeholder="Masukkan nama kategori"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-gray-800" required>
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>
                <button type="submit" 
                        class="inline-flex items-center bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95 gap-2">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
