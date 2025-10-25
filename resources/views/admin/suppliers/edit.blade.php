@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-100 py-12 px-4">
    <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-yellow-600 flex justify-center items-center gap-3">
                <div class="flex items-center justify-center bg-yellow-500 text-white w-14 h-14 rounded-2xl shadow-lg">
                    <i class="fas fa-truck text-2xl"></i>
                </div>
                Edit Supplier
            </h2>
            <p class="text-gray-500 mt-2 text-sm">Perbarui informasi supplier dengan data terbaru agar data tetap akurat.</p>
        </div>

        {{-- ================= NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                Terjadi kesalahan, silakan periksa kembali data Anda.
            </div>
        @endif

        {{-- ================= FORM ================= --}}
        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Supplier --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Supplier</label>
                <input type="text" name="name" value="{{ old('name', $supplier->name) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1 transition" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $supplier->contact_email) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1 transition">
                @error('contact_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                <input type="text" name="contact" value="{{ old('contact', $supplier->contact) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1 transition">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <textarea name="address" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1 transition"
                    placeholder="Masukkan alamat lengkap supplier">{{ old('address', $supplier->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('admin.suppliers.index') }}" 
                   class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md 
                          transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 
                               text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
