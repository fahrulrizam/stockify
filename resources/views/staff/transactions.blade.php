@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center bg-white shadow-sm px-4 py-3 rounded-3 mb-4 border border-light">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-3 me-3"
                 style="width: 40px; height: 40px;">
                <i class="bi bi-list-check fs-5"></i>
            </div>
            <h4 class="fw-bold text-dark mb-0">Konfirmasi Transaksi</h4>
        </div>
        <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>
    </header>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Transaksi Pending -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white fw-semibold rounded-top-4">
            <i class="bi bi-list-check me-2"></i> Daftar Transaksi Pending
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-center text-muted mb-0 py-3">Belum ada transaksi untuk dikonfirmasi</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $t)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td>{{ $t->quantity }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    @if($t->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-success">Confirmed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($t->status === 'pending')
                                    <form action="{{ route('staff.confirmMasuk', $t->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-lg me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-success">Sudah dikonfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links() }} <!-- Pagination -->
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
