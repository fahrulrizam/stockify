@extends('layouts.app')

@section('title', 'Dashboard Staff Gudang')

@section('content')
@php
$cards = [
    [
        'title' => 'Barang Masuk',
        'desc'  => 'Menerima dan memeriksa barang yang datang ke gudang.',
        'icon'  => 'fa-box-arrow-down',
        'iconSmall' => 'fa-box',
        'color' => 'from-blue-500 via-sky-500 to-indigo-500',
        'shadow'=> 'shadow-blue-400/60',
        'route' => route('staff.barangmasuk'),
    ],
    [
        'title' => 'Barang Keluar',
        'desc'  => 'Menyiapkan dan mengirimkan barang keluar ke pelanggan.',
        'icon'  => 'fa-box-arrow-up',
        'iconSmall' => 'fa-truck',
        'color' => 'from-purple-500 via-violet-500 to-indigo-500',
        'shadow'=> 'shadow-purple-400/60',
        'route' => route('staff.barangkeluar'),
    ],
    [
        'title' => 'Stock Opname',
        'desc'  => 'Mengecek dan mencocokkan stok fisik dengan sistem.',
        'icon'  => 'fa-clipboard-check',
        'iconSmall' => 'fa-clipboard',
        'color' => 'from-gray-500 via-slate-400 to-gray-500',
        'shadow'=> 'shadow-gray-400/60',
        'route' => route('staff.stockopname'),
    ],
];
@endphp

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-sky-50 to-fuchsia-50 py-12 relative overflow-hidden animate-fade-in">

    {{-- ================= LATAR PARTIKEL ================= --}}
    <div class="absolute inset-0 z-0">
        @foreach([
            ['bg-indigo-300','top-10','left-20'],
            ['bg-fuchsia-300','top-40','left-60'],
            ['bg-sky-300','top-80','left-40'],
            ['bg-yellow-300','top-80','left-80'],
            ['bg-green-300','top-60','left-10'],
        ] as $dot)
            <div class="absolute w-2 h-2 rounded-full {{ $dot[0] }} animate-bounce-slow {{ $dot[1] }} {{ $dot[2] }}"></div>
        @endforeach
    </div>

    <div class="relative z-10 max-w-7xl mx-auto bg-white/60 backdrop-blur-3xl shadow-2xl rounded-3xl p-10 border border-white/30">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-12 border-b border-blue-200/40 pb-6 gap-6 mouse-parallax">

            {{-- Logo & Nama Aplikasi --}}
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4 rounded-2xl shadow-lg hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-warehouse text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 bg-clip-text text-transparent tracking-tight">
                        {{ $app_name ?? 'Stockify' }}
                    </h1>
                    <p class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-blue-500 to-fuchsia-600 drop-shadow-sm">
                        {{ $company_name ?? 'Operasional Barang & Stok Harian' }}
                    </p>
                </div>
            </div>

            {{-- Waktu Real-Time --}}
            <div class="text-center px-6 py-4 rounded-2xl bg-gradient-to-r from-indigo-300 via-sky-200 to-fuchsia-300 shadow-inner border border-white/50 animate-pulse duration-1000 ease-in-out hover:scale-[1.02] transition-all">
                <p id="tanggal-hari" class="text-gray-800 text-sm font-medium tracking-wide"></p>
                <p id="jam-sekarang" class="text-indigo-900 font-mono text-2xl md:text-3xl mt-1 font-extrabold drop-shadow-sm"></p>
            </div>

            {{-- User Info & Logout --}}
            <div class="flex items-center gap-4 bg-gradient-to-r from-white/40 to-white/60 px-6 py-3 rounded-2xl border border-white/40 shadow-lg backdrop-blur-md hover:shadow-blue-300 transition-shadow duration-300">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                     onerror="this.onerror=null; this.src='https://placehold.co/56x56/2563eb/ffffff?text=U'"
                     alt="Foto Profil"
                     class="w-14 h-14 rounded-full border-2 border-blue-500 shadow-md object-cover hover:scale-110 transition-transform duration-300">

                <div>
                    <p class="font-bold text-gray-800 text-lg">{{ Auth::user()->name ?? 'Staff Gudang' }}</p>
                    <p class="text-sm text-gray-600">{{ ucfirst(Auth::user()->role ?? 'Staff') }}</p>
                </div>

                <a href="#" id="logout-btn"
                   class="ml-4 bg-gradient-to-r from-blue-500 to-sky-500 hover:from-blue-600 hover:to-sky-600 text-white font-semibold px-4 py-2 rounded-xl shadow-lg transition-all transform hover:scale-105 flex items-center gap-2 duration-300">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        {{-- ================= MENU KARTU ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cards as $card)
                <a href="{{ $card['route'] }}" class="group relative bg-gradient-to-br {{ $card['color'] }} text-white rounded-2xl shadow-xl p-6 {{ $card['shadow'] }} hover:scale-105 hover:shadow-2xl transition-all duration-500 mouse-parallax">
                    <div class="absolute right-4 top-4 opacity-10 text-8xl transform rotate-12 group-hover:rotate-6 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                    <div class="w-12 h-12 flex items-center justify-center rounded-full mb-3 shadow-md bg-white/40 border border-white/50">
                        <i class="fas {{ $card['iconSmall'] }} text-xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white/90">{{ $card['title'] }}</h3>
                    <p class="mt-2 text-white/90">{{ $card['desc'] }}</p>
                    <div class="absolute bottom-3 left-3 text-xs bg-black/40 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Klik untuk lihat
                    </div>
                </a>
            @endforeach
        </div>

        {{-- ================= STATISTIK ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
            <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg">
                <h5>Total Produk</h5>
                <h2>{{ $totalProduk ?? 0 }}</h2>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
                <h5>Barang Masuk</h5>
                <h2>{{ $barangMasuk ?? 0 }}</h2>
            </div>
            <div class="bg-purple-500 text-white p-6 rounded-xl shadow-lg">
                <h5>Barang Keluar</h5>
                <h2>{{ $barangKeluar ?? 0 }}</h2>
            </div>
            <div class="bg-yellow-400 text-white p-6 rounded-xl shadow-lg">
                <h5>Stok Menipis</h5>
                <h2>{{ $stokMenipis->count() ?? 0 }}</h2>
            </div>
        </div>

        {{-- ================= TABEL PRODUK ================= --}}
        <div class="card shadow-sm border-0 rounded-4 mt-10 hover-card">
            <div class="card-header text-white fw-semibold" style="background-color: #1e3a8a;">
                <i class="bi bi-box-seam-fill me-2"></i> Daftar Produk
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th>Stok</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                                <tr class="{{ $p->stock <= 5 ? 'table-warning' : '' }}">
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->category->name ?? '-' }}</td>
                                    <td>{{ $p->supplier->name ?? '-' }}</td>
                                    <td class="fw-semibold {{ $p->stock <= 5 ? 'text-danger' : '' }}">{{ $p->stock }}</td>
                                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada data produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= GRAFIK ================= --}}
        @if(isset($chartLabels) && isset($chartData))
        <div class="card shadow-sm border-0 rounded-4 mt-10 p-4 hover-card">
            <h5 class="fw-semibold mb-3">
                <i class="fas fa-chart-bar me-2"></i> Grafik Top 5 Produk (Stok)
            </h5>
            <canvas id="stokChart" height="100"></canvas>
        </div>
        @endif

    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Logout dengan konfirmasi
    const logoutBtn = document.getElementById('logout-btn');
    const logoutForm = document.getElementById('logout-form');

    logoutBtn?.addEventListener('click', e => {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: 'Anda akan keluar dari sistem Stockify.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal',
            background: '#f0f9ff',
            color: '#1e3a8a',
        }).then(result => {
            if(result.isConfirmed) logoutForm.submit();
        });
    });

    // Efek parallax
    document.addEventListener('mousemove', e => {
        const x = (e.clientX / window.innerWidth - 0.5) * 8;
        const y = (e.clientY / window.innerHeight - 0.5) * 8;
        document.querySelectorAll('.mouse-parallax').forEach(el => {
            el.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    // Tanggal & jam real-time
    const tanggalEl = document.getElementById('tanggal-hari');
    const jamEl = document.getElementById('jam-sekarang');

    function updateDateTime() {
        const now = new Date();
        const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        tanggalEl.textContent = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
        const hh = String(now.getHours()).padStart(2,'0');
        const mm = String(now.getMinutes()).padStart(2,'0');
        const ss = String(now.getSeconds()).padStart(2,'0');
        jamEl.textContent = `${hh}:${mm}:${ss}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Chart.js
    @if(isset($chartLabels) && isset($chartData))
    const ctx = document.getElementById('stokChart')?.getContext('2d');
    if(ctx){
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Stok',
                    data: @json($chartData),
                    backgroundColor: '#3b82f6'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }
    @endif
});
</script>

{{-- ================= STYLE ================= --}}
<style>
@keyframes bounce-slow { 0%,100%{transform:translateY(0);opacity:.8;} 50%{transform:translateY(-20px);opacity:.5;} }
.animate-bounce-slow { animation:bounce-slow 6s infinite ease-in-out; }

@keyframes fade-in { from{opacity:0;transform:translateY(30px);} to{opacity:1;transform:translateY(0);} }
.animate-fade-in { animation:fade-in 1s ease-out; }

.hover-card { transition: all 0.3s ease; }
.hover-card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }

.mouse-parallax { transition: transform 0.3s ease-out; will-change: transform; }
</style>
@endsection
