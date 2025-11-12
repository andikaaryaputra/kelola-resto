<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan Waiter</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            color: #333;
            margin: 40px;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            text-transform: uppercase;
        }

        h2 {
            font-size: 16px;
            font-weight: normal;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 14px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
            text-transform: uppercase;
        }

        tfoot th {
            text-align: right;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #555;
        }

        @media print {
            body {
                margin: 20px;
            }
            .footer {
                position: fixed;
                bottom: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Laporan Pesanan Waiter</h1>
    <h2>Periode: {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Meja</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans ?? [] as $p)
                <tr>
                    <td>{{ optional($p->created_at)->format('d M Y H:i') ?? '-' }}</td>
                    <td>{{ optional($p->meja)->nomormeja ?? '-' }}</td>
                    <td>{{ optional($p->pelanggan)->namapelanggan ?? '-' }}</td>
                    <td>{{ ucfirst($p->status ?? '-') }}</td>
                    <td>Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">Tidak ada data pesanan</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Omset</th>
                <th>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Dicetak oleh: {{ auth()->user()->name ?? 'Waiter' }}</p>
        <p><strong>Restaurant Cashier System</strong></p>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
