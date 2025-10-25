@extends('layouts.app')

@section('title', 'Manajemen Produk - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10 border border-gray-200">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mb-10">
            <div class="flex items-center gap-4 sm:gap-6">
                {{-- Ikon --}}
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-box text-white text-3xl"></i>
                </div>
                {{-- Judul --}}
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-indigo-700">
                        Manajemen Produk
                    </h1>
                    <p class="text-gray-500 text-sm sm:text-base mt-1">
                        Kelola seluruh data produk, stok, dan harga barang
                    </p>
                </div>
            </div>

            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.products.create') }}" 
               class="mt-4 sm:mt-0 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition duration-200 flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Tambah Produk
            </a>
        </div>

        {{-- ================= STATISTIK PRODUK ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transition transform">
                <h3 class="text-sm font-semibold opacity-90">Total Produk</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Product::count() }}</p>
            </div>
            <div class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transition transform">
                <h3 class="text-sm font-semibold opacity-90">Stok ≤ 5</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transition transform">
                <h3 class="text-sm font-semibold opacity-90">Produk Aktif</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Product::where('status', 'active')->count() }}</p>
            </div>
            <div class="bg-gradient-to-r from-gray-400 to-gray-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transition transform">
                <h3 class="text-sm font-semibold opacity-90">Produk Nonaktif</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Product::where('status', 'inactive')->count() }}</p>
            </div>
        </div>

        {{-- ================= ALERT SUCCESS ================= --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-check-circle"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ================= TABEL PRODUK ================= --}}
        <div class="overflow-x-auto rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full border-collapse table-auto">
                <thead class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">#</th>
                        <th class="px-5 py-3 text-left font-semibold">Nama Produk</th>
                        <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                        <th class="px-5 py-3 text-left font-semibold">Supplier</th>
                        <th class="px-5 py-3 text-left font-semibold">Harga</th>
                        <th class="px-5 py-3 text-center font-semibold">Stok</th>
                        <th class="px-5 py-3 text-center font-semibold">Status</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $p)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-5 py-3">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-semibold text-gray-800">{{ $p->name }}</td>
                            <td class="px-5 py-3">{{ $p->category->name ?? '-' }}</td>
                            <td class="px-5 py-3">{{ $p->supplier->name ?? '-' }}</td>
                            <td class="px-5 py-3">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-center font-semibold {{ $p->stock <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $p->stock }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $p->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.products.show', $p->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg shadow font-semibold transition flex items-center gap-1">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ route('admin.products.edit', $p->id) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg shadow font-semibold transition flex items-center gap-1">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg shadow font-semibold transition flex items-center gap-1">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-6 italic flex justify-center items-center gap-2">
                                <i class="fas fa-info-circle"></i> Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6 flex justify-center">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @endif

        {{-- ================= KEMBALI KE DASHBOARD ================= --}}
        <div class="text-center mt-8">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
