<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Owner - {{ (isset($from)&&isset($to)) ? (\Carbon\Carbon::parse($from)->format('d/m/Y').' - '.\Carbon\Carbon::parse($to)->format('d/m/Y')) : now()->format('d/m/Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        h1 { margin: 0 0 6px 0; font-size: 22px; }
        .subtitle { color: #666; margin-bottom: 12px; }
        .period { font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        th { background: #f5f5f5; }
        .total-row th, .total-row td { font-weight: bold; background: #fafafa; }
        .section { margin-top: 26px; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; text-align: center; }
        @media print { body { margin: 10px; } }
    </style>
    </head>
<body>
    <h1>Laporan Owner</h1>
    <div class="subtitle">Restaurant Cashier System</div>
    <div class="period">Periode: {{ \Carbon\Carbon::parse($from)->format('d F Y') }} - {{ \Carbon\Carbon::parse($to)->format('d F Y') }}</div>

    <div class="section">
        <h3>Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>No. Transaksi</th>
                    <th>Pesanan</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($transaksi ?? []) as $t)
                <tr>
                    <td>{{ optional($t->created_at)->format('d M Y H:i') ?? '-' }}</td>
                    <td>#{{ $t->idtransaksi ?? '-' }}</td>
                    <td>#{{ $t->idpesanan ?? '-' }}</td>
                    <td>Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->bayar ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->kembali ?? 0, 0, ',', '.') }}</td>
                    <td>{{ strtoupper($t->metode_pembayaran ?? '-') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="3">Total Omset</th>
                    <td colspan="4">Rp {{ number_format($totalOmset ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="section">
        <h3>Pesanan</h3>
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
                @forelse(($pesanans ?? []) as $p)
                <tr>
                    <td>{{ optional($p->created_at)->format('d M Y H:i') ?? '-' }}</td>
                    <td>{{ optional($p->meja)->nomormeja ?? '-' }}</td>
                    <td>{{ optional($p->pelanggan)->namapelanggan ?? '-' }}</td>
                    <td>{{ ucfirst($p->status ?? '-') }}</td>
                    <td>Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="4">Total Nilai Pesanan</th>
                    <td>Rp {{ number_format($totalPesananNominal ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>

