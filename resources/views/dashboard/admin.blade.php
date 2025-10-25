@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md h-screen p-5">
            <h2 class="text-2xl font-bold text-blue-600 mb-6">Admin Panel</h2>
            <ul class="space-y-2">
                <li><a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-blue-100 rounded">🏠 Dashboard</a></li>
                <li><a href="{{ route('categories.index') }}" class="block p-2 hover:bg-blue-100 rounded">📦 Kategori</a></li>
                <li><a href="{{ route('suppliers.index') }}" class="block p-2 hover:bg-blue-100 rounded">🚚 Supplier</a></li>
                <li><a href="{{ route('users.index') }}" class="block p-2 hover:bg-blue-100 rounded">👤 Pengguna</a></li>
                <li><a href="{{ route('reports.index') }}" class="block p-2 hover:bg-blue-100 rounded">📊 Laporan</a></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left p-2 hover:bg-red-100 rounded text-red-600">🚪 Logout</button>
                    </form>
                </li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

            {{-- Statistik --}}
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500">Total Produk</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Product::count() }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500">Total Transaksi</h3>
                    <p class="text-3xl font-bold text-green-600">{{ \App\Models\Transaction::count() }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ \App\Models\User::count() }}</p>
                </div>
            </div>

            {{-- Riwayat Aktivitas --}}
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Riwayat Transaksi Terbaru</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2 border">Tanggal</th>
                            <th class="p-2 border">Produk</th>
                            <th class="p-2 border">Jumlah</th>
                            <th class="p-2 border">Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Transaction::latest()->take(5)->get() as $trx)
                            <tr class="hover:bg-gray-100">
                                <td class="p-2 border">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-2 border">{{ $trx->product->name ?? '-' }}</td>
                                <td class="p-2 border">{{ $trx->quantity }}</td>
                                <td class="p-2 border">
                                    <span class="px-2 py-1 text-sm rounded
                                        {{ $trx->type == 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($trx->type) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection
