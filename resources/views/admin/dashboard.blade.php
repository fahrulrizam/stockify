@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;

// ====================== Ringkasan Data ======================
$cards = [
    [
        'title' => 'Total Produk',
        'count' => Product::count(),
        'color' => 'from-indigo-500 via-sky-500 to-blue-500',
        'icon'  => 'fa-box-open',
        'shadow' => 'shadow-indigo-400/60',
        'tooltip' => 'Produk dengan stok terbanyak: ' . (Product::orderBy('stock','desc')->first()?->name ?? '-'),
    ],
    [
        'title' => 'Total Kategori',
        'count' => Category::count(),
        'color' => 'from-fuchsia-500 via-pink-500 to-rose-500',
        'icon'  => 'fa-tags',
        'shadow' => 'shadow-fuchsia-400/60',
        'tooltip' => 'Kategori paling banyak produk: ' . (Category::withCount('products')->orderBy('products_count','desc')->first()?->name ?? '-'),
    ],
    [
        'title' => 'Total Supplier',
        'count' => Supplier::count(),
        'color' => 'from-green-500 via-teal-500 to-green-500',
        'icon'  => 'fa-truck-loading',
        'shadow' => 'shadow-emerald-400/60',
        'tooltip' => 'Supplier aktif terakhir: ' . (Supplier::latest()->first()?->name ?? '-'),
    ],
    [
        'title' => 'Total Transaksi',
        'count' => Transaction::count(),
        'color' => 'from-purple-500 via-violet-500 to-indigo-500',
        'icon'  => 'fa-file-invoice-dollar',
        'shadow' => 'shadow-purple-400/60',
        'tooltip' => 'Transaksi terakhir: ' . (Transaction::latest()->first()?->id ?? '-'),
    ],
];

// ====================== Navigasi Cepat ======================
$quickLinks = [
    ['route'=>'admin.products.index','icon'=>'fa-box','title'=>'Produk','from'=>'from-indigo-500','to'=>'to-indigo-500','hoverFrom'=>'from-sky-600','hoverTo'=>'to-indigo-600','shadow'=>'shadow-indigo-400/50'],
    ['route'=>'admin.categories.index','icon'=>'fa-tags','title'=>'Kategori','from'=>'from-pink-500','to'=>'to-pink-500','hoverFrom'=>'from-fuchsia-600','hoverTo'=>'to-pink-600','shadow'=>'shadow-fuchsia-400/50'],
    ['route'=>'admin.suppliers.index','icon'=>'fa-truck','title'=>'Supplier','from'=>'from-green-500','to'=>'to-teal-500','hoverFrom'=>'from-emerald-600','hoverTo'=>'to-teal-600','shadow'=>'shadow-emerald-400/50'],
    ['route'=>'admin.transactions.index','icon'=>'fa-exchange-alt','title'=>'Transaksi','from'=>'from-indigo-500','to'=>'to-purple-500','hoverFrom'=>'from-purple-600','hoverTo'=>'to-purple-600','shadow'=>'shadow-indigo-400/50'],
    ['route'=>'admin.stocks.index','icon'=>'fa-boxes','title'=>'Stok','from'=>'from-indigo-500','to'=>'to-blue-500','hoverFrom'=>'from-indigo-600','hoverTo'=>'to-blue-600','shadow'=>'shadow-indigo-400/50'],
    ['route'=>'admin.users.index','icon'=>'fa-users-cog','title'=>'Pengguna','from'=>'from-purple-500','to'=>'to-violet-500','hoverFrom'=>'from-purple-600','hoverTo'=>'to-violet-600','shadow'=>'shadow-purple-400/50'],
    ['route'=>'admin.settings.index','icon'=>'fa-cog','title'=>'Pengaturan','from'=>'from-gray-800','to'=>'to-black','hoverFrom'=>'from-gray-900','hoverTo'=>'to-black','shadow'=>'shadow-gray-500/50'],
];

// ====================== Grafik Top 5 ======================
$topProducts = Product::orderBy('stock', 'desc')->take(5)->get();
$chartLabels = $topProducts->pluck('name');
$chartData   = $topProducts->pluck('stock');
@endphp

<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-sky-50 to-fuchsia-100 py-10 relative overflow-hidden">

    {{-- Background Partikel --}}
    <div class="absolute inset-0 z-0">
        @foreach([
            ['bg-indigo-400','top-10','left-20'],
            ['bg-fuchsia-400','top-40','left-60'],
            ['bg-sky-400','top-80','left-40'],
            ['bg-yellow-400','top-80','left-80'],
            ['bg-green-400','top-60','left-10'],
        ] as $dot)
            <div class="absolute w-2 h-2 rounded-full {{ $dot[0] }} animate-bounce-slow {{ $dot[1] }} {{ $dot[2] }}"></div>
        @endforeach
    </div>

    <div class="relative z-10 max-w-7xl mx-auto bg-white/60 backdrop-blur-3xl shadow-2xl rounded-3xl p-10 border border-white/30">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-10 border-b border-indigo-200/40 pb-6">
            <div class="flex items-center gap-4 mb-6 lg:mb-0">
                <div class="bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4 rounded-2xl shadow-lg hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-warehouse text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 bg-clip-text text-transparent tracking-tight">
                        {{ $app_name ?? 'Stockify' }}
                    </h1>
                    <p class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-blue-500 to-fuchsia-600 drop-shadow-sm">
                        {{ $company_name ?? 'Sistem Manajemen Stok & Gudang Modern' }}
                    </p>
                </div>
            </div>

            {{-- Waktu Real-Time --}}
            <div class="text-center mb-6 lg:mb-0 px-6 py-4 rounded-2xl bg-gradient-to-r from-indigo-300 via-sky-200 to-fuchsia-300 shadow-inner border border-white/50 animate-pulse">
                <p id="current-date" class="text-gray-800 font-medium text-sm"></p>
                <p id="current-time" class="text-indigo-900 font-mono text-2xl mt-1 font-extrabold"></p>
            </div>

            {{-- User & Logout --}}
            <div class="flex items-center gap-4 bg-gradient-to-r from-white/40 to-white/60 px-6 py-3 rounded-2xl border border-white/40 shadow-lg backdrop-blur-md hover:shadow-indigo-300 transition-shadow">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                     onerror="this.onerror=null; this.src='https://placehold.co/56x56/2563eb/ffffff?text=U'"
                     class="w-14 h-14 rounded-full border-2 border-blue-500 shadow-md object-cover hover:scale-110 transition-transform">
                <div>
                    <p class="font-bold text-gray-800 text-lg">{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->name ?? 'admin' }}</p>
                </div>
                <a href="#" id="logout-btn"
                   class="ml-4 bg-gradient-to-r from-blue-500 to-sky-500 hover:from-blue-600 hover:to-sky-600 text-white font-semibold px-4 py-2 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        {{-- Ringkasan Data --}}
        <h2 class="text-2xl font-bold mb-6 text-gray-900 border-b-2 border-gray-300/70 pb-3">Ringkasan Data</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 fade-in">
            @foreach ($cards as $card)
                <div class="group relative bg-gradient-to-br {{ $card['color'] }} text-white rounded-2xl shadow-xl p-6 {{ $card['shadow'] }} hover:scale-105 hover:shadow-2xl transition-all duration-500">
                    <div class="absolute right-4 top-4 opacity-10 text-8xl transform rotate-12 group-hover:rotate-6 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white/90">{{ $card['title'] }}</h3>
                    <p class="text-5xl font-extrabold mt-3 drop-shadow-sm">{{ number_format($card['count'], 0, ',', '.') }}</p>
                    <div class="absolute bottom-3 left-3 text-xs bg-black/40 px-2 py-1 rounded max-w-[90%] truncate opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ $card['tooltip'] }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Navigasi Cepat --}}
        <div class="bg-gradient-to-br rounded-3xl shadow-xl p-8 border border-white/50 backdrop-blur-md hover:shadow-purple-300 transition-shadow mb-10">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 border-b border-gray-300/60 pb-3 flex items-center gap-3">
                <i class="fas fa-compass text-indigo-600 animate-spin-slow"></i>
                Navigasi Cepat
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-6 text-center">
                @foreach($quickLinks as $index => $link)
                    <a href="{{ route($link['route']) }}"
                       class="menu-btn opacity-0 translate-y-6 bg-gradient-to-r {{ $link['from'] }} {{ $link['to'] }}
                              hover:{{ $link['hoverFrom'] }} hover:{{ $link['hoverTo'] }} text-white shadow-lg {{ $link['shadow'] }}"
                       style="animation-delay: {{ $index * 0.2 }}s">
                        <i class="fas {{ $link['icon'] }} text-3xl mb-2 animate-bounce-slow"></i>
                        {{ $link['title'] }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grafik Stok --}}
        <div class="p-6 bg-white rounded-xl shadow-lg mb-10 border border-gray-200/50 fade-in">
            <h2 class="text-xl font-semibold mb-4 border-b pb-2">
                <i class="fas fa-chart-bar mr-2"></i> Grafik Stok Barang (Top 5)
            </h2>
            <canvas id="stockChart" height="100"></canvas>
        </div>
    </div>
</div>

{{-- ================= Script ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Realtime Clock
    const updateDateTime = () => {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
    };
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Chart.js
    const ctx = document.getElementById('stockChart');
    if (ctx && typeof Chart !== 'undefined') {
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102,126,234,0.8)');
        gradient.addColorStop(1, 'rgba(102,126,234,0.3)');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: gradient,
                    borderRadius: 10,
                    barPercentage: 0.6
                }]
            },
            options: {
                scales: { y: { beginAtZero: true }},
                plugins: { legend: { display: false }},
                animation: { duration: 1500, easing: 'easeOutBounce' }
            }
        });
    }

    // Logout Alert
    document.getElementById('logout-btn').addEventListener('click', e => {
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
            customClass: {
                popup: 'rounded-3xl shadow-2xl border border-blue-200',
                confirmButton: 'px-4 py-2 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all',
                cancelButton: 'px-4 py-2 rounded-xl font-semibold bg-gray-200 hover:bg-gray-300 transition-all'
            },
        }).then(result => {
            if(result.isConfirmed) document.getElementById('logout-form').submit();
        });
    });

    // Animasi masuk
    document.querySelectorAll('.fade-in').forEach((el,i) => setTimeout(() => el.classList.add('visible'), i*100));
    document.querySelectorAll('.menu-btn').forEach((btn,i) => setTimeout(() => {
        btn.classList.add('animate-fade-in-up');
        btn.classList.remove('opacity-0','translate-y-6');
    }, i*150));
});
</script>

<style>
/* Animasi Partikel & Menu */
@keyframes bounce-slow {0%,100%{transform:translateY(0);opacity:.8}50%{transform:translateY(-20px);opacity:.5}}
.animate-bounce-slow {animation:bounce-slow 6s infinite ease-in-out}

@keyframes fade-in-up {0%{opacity:0;transform:translateY(10px)}100%{opacity:1;transform:translateY(0)}}
.animate-fade-in-up {animation:fade-in-up 0.6s ease forwards}

.fade-in {opacity:0;transform:translateY(10px);transition:.5s ease-out}
.fade-in.visible {opacity:1;transform:translateY(0)}

.menu-btn {display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.5rem;border-radius:1rem;font-weight:700;transition:all .3s ease-in-out}
.menu-btn:hover {transform:scale(1.07)}

.animate-spin-slow {animation:spin 6s linear infinite}
@keyframes spin {100%{transform:rotate(360deg)}}
</style>
@endsection
