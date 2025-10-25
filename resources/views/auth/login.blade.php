<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Stockify</title>

    {{-- Gunakan CDN Tailwind agar tidak perlu Vite --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-xl shadow-lg w-80 border border-gray-200">
        <h2 class="text-2xl font-bold mb-5 text-center text-blue-600">Login</h2>

        {{-- Pesan error login --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-md text-sm">
                {{ $errors->first() }}
            </div>
        @endif
@if (session('status'))
    <div class="alert alert-success text-center fw-semibold rounded-3">
        {{ session('status') }}
    </div>
@endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Masukkan email" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Masukkan password" required>
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold w-full py-2 rounded-md transition">
                Login
            </button>
        </form>
    </div>

</body>
</html>
