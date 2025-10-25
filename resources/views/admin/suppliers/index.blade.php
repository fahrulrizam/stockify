@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-100 py-10 px-4">
    <div class="max-w-7xl mx-auto bg-white shadow-2xl rounded-3xl p-8 md:p-10 border border-indigo-100">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-indigo-100 pb-6">
            <div class="flex items-center gap-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl text-white shadow-lg mb-4">
                <i class="fas fa-truck-field text-2xl"></i>
            </div>
                <div>
                     <h2 class="text-3xl font-extrabold text-green-600 flex justify-center items-center gap-2">Daftar Supplier</h2>
                    <p class="text-gray-500 text-sm">Manajemen data supplier dan mitra pemasok</p>
                </div>
            </div>
            <a href="{{ route('admin.suppliers.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
               ➕ Tambah Supplier
            </a>
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm flex items-center gap-2">
                ✅ <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- STATISTIK SUPPLIER --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Total Supplier</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Supplier::count() }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Supplier Punya Produk</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Supplier::has('products')->count() }}</p>
            </div>
            <div class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-xl shadow-md p-6 hover:scale-105 transform transition">
                <h3 class="text-sm font-semibold opacity-90">Supplier Belum Punya Produk</h3>
                <p class="text-3xl md:text-4xl font-bold mt-2">{{ \App\Models\Supplier::doesntHave('products')->count() }}</p>
            </div>
        </div>

        {{-- TABEL SUPPLIER --}}
        <div class="overflow-x-auto rounded-2xl shadow-md">
            <table class="min-w-full table-auto border-collapse border border-indigo-100">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left w-12">#</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Telepon</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-indigo-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $supplier->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $supplier->contact_email ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $supplier->contact ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $supplier->address ?? '-' }}</td>
                            <td class="px-4 py-3 text-center flex flex-col md:flex-row items-center justify-center gap-2 md:gap-1">
                                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" 
                                   class="flex-1 md:flex-none inline-flex items-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition transform hover:scale-105 active:scale-95 justify-center">
                                   ✏️ Edit
                                </a>
                                <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" 
                                      method="POST" class="flex-1 md:flex-none w-full md:w-auto"
                                      onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full md:w-auto inline-flex items-center gap-1 bg-red-600 text-white px-3 py-1 rounded-lg shadow hover:bg-red-700 transition transform hover:scale-105 active:scale-95 justify-center">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6 flex items-center justify-center gap-2">
                                ℹ️ Tidak ada data supplier.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($suppliers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6 flex justify-center">
                {{ $suppliers->links('pagination::tailwind') }}
            </div>
        @endif

        {{-- KEMBALI --}}
        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
