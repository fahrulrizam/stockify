<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px 10px;
        }

        th {
            background-color: #d1f2eb;
            color: #2c3e50;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8f9f9;
        }

        td {
            vertical-align: middle;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Laporan Barang Masuk</h2>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:45%;">Nama Produk</th>
                <th style="width:15%;">Jumlah Masuk</th>
                <th style="width:25%;">Tanggal Transaksi</th>
                <th style="width:10%;">User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td>{{ $t->product->name ?? '-' }}</td>
                    <td style="text-align:center;">{{ $t->quantity }}</td>
                    <td style="text-align:center;">
                        {{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y, H:i') }}
                    </td>
                    <td style="text-align:center;">{{ $t->user->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#888;">Belum ada data barang masuk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
    </div>
</body>
</html>
