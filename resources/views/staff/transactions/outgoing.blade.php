@extends('layouts.app')

@section('title', 'Barang Keluar - Stockify')

@section('content')
<div class="min-vh-100 py-5" style="background: linear-gradient(to bottom right, #f3e8ff, #ede9fe);">

    <div class="container">
        <div class="bg-white/90 backdrop-blur-lg border border-2 border-light shadow-lg rounded-4 p-5">

            {{-- ================= HEADER ================= --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                   <h2 class="fw-bold text-purple-500 mb-1">
                    <i class="bi bi-box-arrow-up me-2"></i> Barang Keluar
                    </h2>

                    <p class="text-muted mb-0">Lihat dan kelola seluruh transaksi barang keluar dari gudang</p>
                </div>
                <a href="{{ route('staff.dashboard') }}" 
                   class="btn btn-dashboard rounded-pill shadow-sm">
                   <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Dashboard
                </a>
            </div>

            {{-- ================= NOTIFIKASI ================= --}}
            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 rounded-pill px-4 py-2">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger shadow-sm border-0 rounded-pill px-4 py-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- ================= TABEL BARANG KELUAR ================= --}}
            <div class="table-responsive mt-4">
                <table class="table table-hover align-middle text-center shadow-sm rounded-4 overflow-hidden">
                    <thead class="text-white" style="background: linear-gradient(90deg, #4338ca, #2563eb);">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr class="table-row-hover">
                                <td class="fw-semibold">{{ $loop->iteration }}</td>
                                <td class="text-start ps-4 fw-semibold text-dark">
                                    {{ $transaction->product->name ?? '-' }}
                                </td>
                                <td>
                                <span class="badge" style="background-color: #7c3aed; color: white; font-size: 1rem;">
                                 {{ $transaction->quantity }}
                                </span>
                                </td>
                                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    @if($transaction->confirmed)
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check2-circle me-1"></i> Terkonfirmasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$transaction->confirmed)
                                        <form action="{{ route('staff.barangkeluar.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold">
                                                <i class="bi bi-check-lg me-1"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary rounded-pill px-3 fw-semibold" disabled>
                                            <i class="bi bi-lock-fill me-1"></i> Selesai
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">
                                    <i class="bi bi-inbox me-1"></i> Belum ada data barang keluar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ================= PAGINATION ================= --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- ================= TAMBAHAN CSS ================= --}}
<style>
    .btn-dashboard {
        background-color: white;
        color: #4f46e5; /* ungu */
        border: 1px solid #d1d5db;
        transition: all 0.3s ease;
    }
    .btn-dashboard:hover {
        background: linear-gradient(90deg, #7c3aed, #a855f7);
        color: white;
    }
    .table-row-hover:hover {
        background-color: #eef2ff !important;
        transition: all 0.25s ease-in-out;
    }
</style>
@endsection
