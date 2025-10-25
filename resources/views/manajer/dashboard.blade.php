@extends('layouts.app')

@section('title', 'Dashboard Manajer')

@section('content')
<div class="relative container-fluid py-5 overflow-hidden"
     style="background: linear-gradient(135deg, #e0f2fe, #dbeafe); min-height: 100vh;">

    {{-- ==================== LATAR PARTIKEL ==================== --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        @foreach([
            ['bg-blue-400/50','top-[10%]','left-[20%]'],
            ['bg-sky-400/40','top-[40%]','left-[60%]'],
            ['bg-cyan-400/50','top-[70%]','left-[40%]'],
            ['bg-indigo-400/50','top-[80%]','left-[80%]'],
            ['bg-blue-300/50','top-[55%]','left-[10%]'],
        ] as $dot)
            <div class="absolute w-3 h-3 rounded-full {{ $dot[0] }} blur-sm animate-bounce-slow {{ $dot[1] }} {{ $dot[2] }} mouse-parallax"></div>
        @endforeach
    </div>

    {{-- ==================== HEADER ==================== --}}
    <div class="flex flex-col lg:flex-row justify-between items-center mb-12 border-b border-blue-200/40 pb-6 mouse-parallax">

        {{-- Logo & Judul --}}
        <div class="flex items-center gap-4 mb-6 lg:mb-0">
            <div class="bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4 rounded-2xl shadow-lg hover:scale-110 transition-transform duration-300">
                <i class="fas fa-warehouse text-2xl"></i>
            </div>
            <div>
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-700 via-sky-600 to-cyan-500 bg-clip-text text-transparent tracking-tight">
                    {{ $app_name ?? 'Stockify' }}
                </h1>
                <p class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-blue-500 to-fuchsia-600 drop-shadow-sm">
                    {{ $company_name ?? 'Manajemen Gudang & Inventaris' }}
                </p>
            </div>
        </div>

        {{-- Waktu Real-Time --}}
        <div class="flex flex-col items-center justify-center text-center 
                    px-6 py-4 rounded-2xl 
                    bg-gradient-to-r from-indigo-300 via-sky-200 to-fuchsia-300 
                    shadow-inner border border-white/50 
                    animate-pulse duration-1000 ease-in-out
                    hover:shadow-lg hover:scale-[1.02] transition-all">
            <p id="tanggal-hari" class="text-gray-800 text-sm font-medium tracking-wide"></p>
            <p id="jam-sekarang" class="text-indigo-900 font-mono text-2xl md:text-3xl mt-1 font-extrabold drop-shadow-sm"></p>
        </div>

        {{-- Info User & Logout --}}
        <div class="flex items-center gap-4 bg-white/50 px-6 py-3 rounded-2xl border border-white/40 shadow-lg backdrop-blur-md hover:shadow-blue-300 transition-shadow duration-300">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                 onerror="this.onerror=null; this.src='https://placehold.co/56x56/2563eb/ffffff?text=U'"
                 class="w-14 h-14 rounded-full border-2 border-blue-500 shadow-md object-cover hover:scale-110 transition-transform duration-300"
                 alt="Foto Profil">

            <div>
                <p class="font-bold text-gray-800 text-lg">{{ Auth::user()->name ?? 'Manajer' }}</p>
                <p class="text-sm text-gray-600">{{ ucfirst(Auth::user()->role ?? 'manajer') }}</p>
            </div>

            {{-- Tombol Logout --}}
            <a href="#" id="logout-btn"
               class="ml-4 bg-gradient-to-r from-blue-600 to-sky-500 hover:from-blue-700 hover:to-sky-600 text-white font-semibold px-4 py-2 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    {{-- ==================== STATISTIK CARD ==================== --}}
    <div class="row g-4 mb-4">
        @php
            $stats = [
                ['title'=>'Total Produk', 'value'=>$totalProduk ?? 0, 'color'=>'#1e3a8a', 'icon'=>'fa-box'],
                ['title'=>'Barang Masuk', 'value'=>$barangMasuk ?? 0, 'color'=>'#16a34a', 'icon'=>'fa-arrow-down'],
                ['title'=>'Barang Keluar', 'value'=>$barangKeluar ?? 0, 'color'=>'#dc2626', 'icon'=>'fa-arrow-up'],
                ['title'=>'Stok Menipis', 'value'=>$stokMenipis->count() ?? 0, 'color'=>'#facc15', 'icon'=>'fa-exclamation-triangle'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="col-md-3">
            <div class="card border-0 shadow-md rounded-4 text-center text-white hover-card"
                 style="background-color: {{ $s['color'] }}">
                <div class="card-body py-4">
                    <i class="fas {{ $s['icon'] }} mb-2" style="font-size:24px;"></i>
                    <h6 class="fw-semibold mb-1">{{ $s['title'] }}</h6>
                    <h2 class="fw-bold">{{ $s['value'] }}</h2>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ==================== AKSI CEPAT ==================== --}}
    <div class="d-flex flex-wrap gap-3 mb-5 mouse-parallax">
        <a href="{{ route('manajer.barangmasuk.export', ['format'=>'pdf'] + request()->query()) }}" 
           class="btn btn-danger shadow-sm hover-card rounded-3 flex-grow-1">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('manajer.barangmasuk') }}" 
           class="btn btn-success shadow-sm hover-card rounded-3 flex-grow-1">
            <i class="bi bi-box-arrow-in-down me-1"></i> Barang Masuk
        </a>
       <a href="{{ route('manajer.barangkeluar') }}" 
   class="btn text-white shadow-sm hover-card rounded-3 flex-grow-1 transition-all" 
   style="background-color: #dc2626; border:none;">
    <i class="bi bi-box-arrow-up me-1"></i> Barang Keluar
</a>

        <a href="{{ route('manajer.barangmenipis') }}" 
           class="btn shadow-sm hover-card rounded-3 flex-grow-1" style="background-color: #facc15; color: #1f2937;">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Barang Menipis
        </a>
    </div>

    {{-- ==================== DAFTAR SUPPLIER ==================== --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 hover-card">
        <div class="card-header text-white fw-semibold" style="background-color: #16a34a;">
            <i class="bi bi-truck me-2"></i> Daftar Supplier
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->contact_email ?? '-' }}</td>
                                <td>{{ $supplier->contact ?? '-' }}</td>
                                <td>{{ $supplier->address ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada data supplier</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== DAFTAR PRODUK ==================== --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 hover-card">
        <div class="card-header d-flex justify-content-between align-items-center text-white fw-semibold" style="background-color: #1e3a8a;">
            <span><i class="bi bi-box-seam me-2"></i> Daftar Produk</span>
            <a href="{{ route('manajer.products.index') }}" class="btn btn-light text-blue-800 fw-semibold px-3 py-1 rounded">
                <i class="bi bi-gear-fill me-1"></i> Kelola Produk
            </a>
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
                            <th>Status</th>
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
                                <td>
                                    @php
                                        if ($p->stock == 0) { $status='Habis'; $color='bg-red-500 text-white'; }
                                        elseif ($p->stock <=5) { $status='Menipis'; $color='bg-yellow-400 text-black'; }
                                        else { $status='Aman'; $color='bg-green-500 text-white'; }
                                    @endphp
                                    <span class="px-2 py-1 rounded {{ $color }}">{{ $status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Tidak ada data produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== GRAFIK ==================== --}}
    @if(isset($chartLabels) && isset($chartData))
    <div class="card shadow-sm border-0 rounded-4 mb-4 p-4 hover-card">
        <h5 class="fw-semibold mb-3"><i class="fas fa-chart-bar me-2"></i> Grafik Top 5 Produk (Stok)</h5>
        <canvas id="stokChart" height="100"></canvas>
    </div>
    @endif
</div>

{{-- ==================== STYLE & SCRIPT ==================== --}}
<style>
.mouse-parallax { transition: transform 0.2s ease-out; will-change: transform; }
.hover-card { transition: all 0.3s ease; }
.hover-card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }
@keyframes bounce-slow { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
.animate-bounce-slow { animation: bounce-slow 5s infinite ease-in-out; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Logout konfirmasi
    const logoutBtn = document.getElementById('logout-btn');
    const logoutForm = document.getElementById('logout-form');
    if(logoutBtn){
        logoutBtn.addEventListener('click', e=>{
            e.preventDefault();
            Swal.fire({
                title:'Yakin ingin keluar?',
                text:"Anda akan keluar dari sistem Stockify.",
                icon:'question',
                showCancelButton:true,
                confirmButtonColor:'#2563eb',
                cancelButtonColor:'#94a3b8',
                confirmButtonText:'Ya, keluar',
                cancelButtonText:'Batal',
                background:'#f0f9ff',
                color:'#1e3a8a'
            }).then(result=>{ if(result.isConfirmed) logoutForm.submit(); });
        });
    }

    // Parallax efek
    document.addEventListener("mousemove", e=>{
        const x = (e.clientX/window.innerWidth-0.5)*8;
        const y = (e.clientY/window.innerHeight-0.5)*8;
        document.querySelectorAll(".mouse-parallax").forEach(el=>{
            el.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    // Tanggal & jam
    const tanggalEl = document.getElementById("tanggal-hari");
    const jamEl = document.getElementById("jam-sekarang");
    function updateDateTime(){
        const now = new Date();
        const hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        tanggalEl.textContent = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
        jamEl.textContent = now.toLocaleTimeString('id-ID',{hour12:false});
    }
    updateDateTime();
    setInterval(updateDateTime,1000);

    // Chart
    @if(isset($chartLabels) && isset($chartData))
    const ctx = document.getElementById('stokChart')?.getContext('2d');
    if(ctx){
        new Chart(ctx,{
            type:'bar',
            data:{ labels:@json($chartLabels), datasets:[{ label:'Jumlah Stok', data:@json($chartData), backgroundColor:'#3b82f6' }] },
            options:{ responsive:true, scales:{ y:{ beginAtZero:true } } }
        });
    }
    @endif
});
</script>
@endsection
