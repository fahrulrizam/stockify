@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-100 via-indigo-50 to-blue-100 py-12 px-4">
    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md shadow-2xl rounded-3xl p-8 md:p-10">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-4">
            <div class="flex items-center gap-3">
                <i class="fas fa-users text-3xl text-purple-700"></i>
                <h1 class="text-3xl md:text-4xl font-extrabold text-purple-700">
                    Manajemen Pengguna
                </h1>
            </div>
           
        </div>

        {{-- ================= PESAN SUKSES ================= --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl shadow flex items-center gap-2 border border-green-200">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ================= TABEL PENGGUNA ================= --}}
        <div class="overflow-x-auto rounded-2xl shadow-md border border-gray-200">
            <table class="min-w-full table-auto divide-y divide-gray-200 text-gray-800">
                <thead class="bg-purple-100 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">Nama</th>
                        <th class="px-5 py-3 text-left font-semibold">Email</th>
                        <th class="px-5 py-3 text-center font-semibold">Role</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-5 py-3 font-medium">{{ $user->name }}</td>
                            <td class="px-5 py-3">{{ $user->email }}</td>
                            <td class="px-5 py-3 text-center">{{ ucfirst($user->role) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-6 italic flex items-center justify-center gap-2">
                                <i class="fas fa-info-circle"></i> Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= TOMBOL KEMBALI ================= --}}
        <div class="text-center mt-10">
           <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 active:scale-95">
               ⬅️ Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
