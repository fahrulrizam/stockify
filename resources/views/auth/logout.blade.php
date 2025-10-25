@extends('layouts.app')

@section('title', 'Logout - Stockify')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-sky-50 to-fuchsia-100">
    <div class="bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-10 text-center border border-white/50 animate-fadeInUp max-w-md w-full">
        <div class="mb-6">
            <img src="{{ asset('storage/logos/logo.jpg') }}" alt="Logo" class="w-24 h-24 mx-auto rounded-full shadow-md border border-gray-300">
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-3">Anda Telah Logout</h1>
        <p class="text-gray-600 mb-6">Terima kasih telah menggunakan <strong>Stockify</strong>.<br>
        Klik tombol di bawah ini untuk masuk kembali ke sistem.</p>
        <a href="{{ route('login') }}" 
           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:from-indigo-600 hover:to-blue-600 transition-all transform hover:scale-[1.05]">
            <i class="fas fa-sign-in-alt"></i> Masuk Kembali
        </a>
    </div>
</div>
<p class="text-sm text-gray-500 mt-4">Anda akan diarahkan ke halaman login dalam <span id="countdown">5</span> detik...</p>

<script>
    let seconds = 5;
    const countdown = document.getElementById('countdown');
    const timer = setInterval(() => {
        seconds--;
        countdown.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('login') }}";
        }
    }, 1000);
</script>


<style>
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fadeInUp { animation: fadeInUp 0.7s ease-out forwards; }
</style>
@endsection
