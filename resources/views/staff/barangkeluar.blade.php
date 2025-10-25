@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body">
            <h4 class="fw-bold text-dark mb-3">
                <i class="bi bi-box-arrow-up"></i> Barang Keluar
            </h4>
            <p class="text-muted mb-4">Daftar barang yang dikirim ke pelanggan.</p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($data->isEmpty())
                <p class="text-center text-muted">Belum ada data barang keluar.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead class="table-secondary">
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
                        @foreach ($data as $trx)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trx->product->name ?? '-' }}</td>
                                <td>{{ $trx->quantity }}</td>
                                <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $trx->status == 'selesai' ? 'success' : 'warning' }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($trx->status != 'selesai')
                                        <form action="{{ route('staff.konfirmasi.keluar', $trx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('staff.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
