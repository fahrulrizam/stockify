<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajer Gudang')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: "Inter", sans-serif;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #1e1f22;
            color: #fff;
            position: fixed;
            width: 220px;
            display: flex;
            flex-direction: column;
            padding: 25px 15px;
        }
        .sidebar h4 {
            color: #4f83ff;
            font-weight: 800;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.2rem;
        }
        .sidebar a {
            color: #cfcfcf;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.2s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #2b2d31;
            color: #fff;
        }
        .sidebar a.active {
            background-color: #2b63f1;
            color: #fff;
            font-weight: 600;
        }
        .sidebar .btn-export {
            background-color: #dc3545;
            color: #fff;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: 0.2s;
            font-size: 0.9rem;
        }
        .sidebar .btn-export:hover {
            background-color: #b02a37;
            color: #fff;
        }

        /* Konten */
        .content {
            margin-left: 240px;
            padding: 25px;
            min-height: 100vh;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 15px;
                overflow-x: auto;
            }
            .sidebar h4 {
                display: none;
            }
            .content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h4><i class="bi bi-box-seam me-2"></i>STOKIFY</h4>

        <a href="{{ route('manajer.dashboard') }}" class="{{ request()->routeIs('manajer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="{{ route('manajer.stocks.index') }}" class="{{ request()->routeIs('manajer.stocks.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data me-2"></i> Laporan Stok
        </a>

        <a href="{{ route('manajer.stocks.exportPdf', request()->query()) }}" class="btn-export mt-2">
            <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
        </a>

        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 mt-3">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
