@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-lg p-4 rounded-4" style="width: 400px;">
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center"
                 style="width: 60px; height: 60px;">
                <i class="bi bi-person-badge fs-3"></i>
            </div>
            <h4 class="mt-3 fw-bold text-primary">Login Staff Gudang</h4>
            <p class="text-muted small">Masuk untuk mengelola operasional gudang</p>
        </div>

        <form method="POST" action="{{ route('staff.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none small text-secondary">
                ← Kembali ke login utama
            </a>
        </div>
    </div>
</div>
@endsection
