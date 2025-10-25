@extends('layouts.app')

@section('title', 'Barang Masuk - Stockify')

@section('content')
<div class="min-vh-100 py-5" style="background: linear-gradient(to bottom right, #e0f2fe, #eef2ff);">

    <div class="container">
        <div class="bg-white/90 backdrop-blur-lg border border-2 border-light shadow-lg rounded-4 p-5">

            {{-- ================= HEADER ================= --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        <i class="bi bi-box-arrow-in-down me-2"></i> Barang Masuk
                    </h2>
                    <p class="text-muted mb-0">Daftar seluruh transaksi barang masuk ke gudang</p>
                </div>
                <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-primary rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Dashboard
                </a>
            </div>

            {{-- ================= NOTIFIKASI ================= --}}
            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 rounded-pill px-4">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger shadow-sm border-0 rounded-pill px-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- ================= TABEL BARANG MASUK ================= --}}
            <div class="table-responsive mt-4">
                <table class="table table-hover align-middle text-center shadow-sm rounded-4 overflow-hidden">
                    <thead class="text-white" style="background: linear-gradient(90deg, #1e3a8a, #2563eb);">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                            <tr class="table-row-hover">
                                <td class="fw-semibold">{{ $loop->iteration }}</td>
                                <td class="text-start ps-4 fw-semibold text-dark">
                                    {{ $transaction->product->name ?? '-' }}
                                </td>
                                <td><span class="badge bg-primary fs-6">{{ $transaction->quantity }}</span></td>
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
                                        <form action="{{ route('staff.barangmasuk.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-check-lg me-1"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>
                                            <i class="bi bi-lock-fill me-1"></i> Selesai
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">
                                    <i class="bi bi-inbox me-1"></i> Belum ada data barang masuk.
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

{{-- ================= TAMBAHAN CSS HOVER ================= --}}
<style>
    .table-row-hover:hover {
        background-color: #f8fafc !important;
        transition: background-color 0.2s ease-in-out;
    }
</style>
@endsection
