@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="relative min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-indigo-200 overflow-hidden">
    {{-- Partikel Latar --}}
    <canvas id="particle-canvas" class="absolute inset-0 w-full h-full"></canvas>

    <div class="container mx-auto py-16 relative z-10">
        {{-- Kartu Konten --}}
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
            <h2 class="text-2xl font-semibold text-indigo-700 mb-6">Pengaturan Aplikasi</h2>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error') || $errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg shadow-sm">
                    Terjadi kesalahan saat menyimpan pengaturan.
                </div>
            @endif

            <form id="settings-form" action="{{ route('admin.settings.save') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nama Aplikasi --}}
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Nama Aplikasi</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}"
                        class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:border-transparent outline-none">
                    @error('app_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol aksi --}}
                <div class="flex justify-between mt-8">
                    <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-md transition transform hover:scale-105 active:scale-95">
                   ⬅️ Kembali
                </a>
                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold hover:from-indigo-500 hover:to-blue-500 transition transform hover:scale-105 shadow-md">
                        💾 Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const canvas = document.getElementById('particle-canvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const particles = Array.from({length: 50}, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    r: Math.random() * 3 + 1,
    dx: (Math.random() - 0.5) * 0.5,
    dy: (Math.random() - 0.5) * 0.5,
}));

function animateParticles(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    particles.forEach(p => {
        p.x += p.dx;
        p.y += p.dy;
        if(p.x < 0 || p.x > canvas.width) p.dx *= -1;
        if(p.y < 0 || p.y > canvas.height) p.dy *= -1;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
        ctx.fillStyle = 'rgba(100,100,255,0.3)';
        ctx.fill();
    });
    requestAnimationFrame(animateParticles);
}
animateParticles();
</script>
@endsection
