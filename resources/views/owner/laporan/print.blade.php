<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Owner - {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        h1 { margin: 0 0 6px 0; font-size: 22px; }
        .subtitle { color: #666; margin-bottom: 12px; }
        .period { font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        th { background: #f5f5f5; }
        .total-row th, .total-row td { font-weight: bold; background: #fafafa; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; text-align: center; }
        @media print { body { margin: 10px; } }
    </style>
</head>
<body>
    <h1>Laporan Owner</h1>
    <div class="subtitle">Restaurant Cashier System</div>
    <div class="period">
        Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>No. Transaksi</th>
                <th>ID Pesanan</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembali</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($transaksi ?? []) as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                <td>#{{ $t->idtransaksi ?? '-' }}</td>
                <td>#{{ $t->idpesanan ?? '-' }}</td>
                <td>{{ $t->kasir ?? '-' }}</td>
                <td>Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->bayar ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->kembali ?? 0, 0, ',', '.') }}</td>
                <td>{{ strtoupper($t->metode_pembayaran ?? '-') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <th colspan="4">Total Omset</th>
                <td colspan="4">Rp {{ number_format($totalOmset ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => window.print(), 1000);
        }
    </script>
</body>
</html>
