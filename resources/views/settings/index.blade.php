@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-100 py-10 px-4 relative overflow-hidden">

    {{-- ================= PARTIKEL LATAR ================= --}}
    <canvas id="particle-canvas" class="absolute inset-0 w-full h-full"></canvas>

    <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200 relative z-10">
        
        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-indigo-700">Pengaturan Aplikasi</h1>
                <p class="text-gray-600 mt-1">Ubah informasi dasar sistem dan perusahaan</p>
            </div>
        </div>

        {{-- ================= PESAN SUKSES ================= --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl border border-green-300 shadow-sm flex items-center">
                <i class="fa fa-check-circle mr-2 text-green-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ================= FORM ================= --}}
        <form id="settings-form" action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Aplikasi --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Aplikasi</label>
                <input type="text" name="app_name" value="{{ old('app_name', $app_name) }}"
                    class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-300 outline-none shadow-sm transition">
                @error('app_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Perusahaan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Perusahaan</label>
                <input type="text" name="company_name" value="{{ old('company_name', $company_name) }}"
                    class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-300 outline-none shadow-sm transition">
                @error('company_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
                <button type="submit" 
                    class="flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold hover:from-indigo-500 hover:to-blue-500 shadow-md transition transform hover:scale-105 active:scale-95">
                    <i class="fa fa-save mr-2"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= PARTIKEL ANIMASI ================= --}}
@section('scripts')
<script>
const canvas = document.getElementById('particle-canvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const particles = Array.from({ length: 50 }, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    r: Math.random() * 3 + 1,
    dx: (Math.random() - 0.5) * 0.5,
    dy: (Math.random() - 0.5) * 0.5,
}));

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
        p.x += p.dx;
        p.y += p.dy;

        if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > canvas.height) p.dy *= -1;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(99,102,241,0.25)';
        ctx.fill();
    });
    requestAnimationFrame(animate);
}
animate();

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>
@endsection
