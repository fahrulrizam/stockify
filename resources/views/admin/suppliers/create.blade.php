@extends('layouts.app')

@section('title', 'Tambah Supplier - Stockify')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 py-12 px-4 relative overflow-hidden">

    {{-- LATAR DEKORASI --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute w-72 h-72 bg-green-200/50 rounded-full blur-3xl top-10 left-10 animate-pulse"></div>
        <div class="absolute w-64 h-64 bg-emerald-300/50 rounded-full blur-3xl bottom-20 right-20 animate-ping"></div>
    </div>

    <div class="max-w-4xl mx-auto bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-10 border border-green-100">

        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl text-white shadow-lg mb-4">
                <i class="fas fa-truck-field text-2xl"></i>
            </div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-green-600 via-emerald-500 to-lime-500 bg-clip-text text-transparent">
                Tambah Supplier
            </h2>
            <p class="text-gray-600 text-sm mt-2">
                Lengkapi data supplier untuk keperluan manajemen stok dan pengadaan barang.
            </p>
        </div>

        {{-- ================= FORM ================= --}}
        <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Supplier --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Masukkan nama supplier"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                       placeholder="contoh: supplier@email.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition">
                @error('contact_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                <input type="text" name="contact" value="{{ old('contact') }}"
                       placeholder="Masukkan nomor telepon aktif"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap supplier"
                          class="w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1 transition">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                <a href="{{ route('admin.suppliers.index') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
                    ⬅️ Kembali
                </a>

                <button type="submit"
                        class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-2xl shadow-lg transition-all duration-300 hover:scale-105 active:scale-95">
                     💾 <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= STYLE TAMBAHAN ================= --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .animate-ping { animation: ping 6s infinite alternate ease-in-out; opacity: 0.8; }
    .animate-pulse { animation: float 5s infinite ease-in-out; }
</style>
@endsection
