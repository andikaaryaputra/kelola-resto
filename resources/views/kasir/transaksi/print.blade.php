<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->idtransaksi }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #111; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h1 { font-size: 18px; margin: 0; }
        .muted { color: #666; font-size: 12px; }
        .row { display: flex; justify-content: space-between; margin: 4px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 6px 4px; border-bottom: 1px dashed #ccc; font-size: 13px; }
        tfoot td { border-top: 1px solid #000; font-weight: bold; }
        .totals { margin-top: 10px; font-weight: bold; }
        @media print { body { margin: 8px; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>Restaurant Cashier</h1>
        <div class="muted">Jl. Example No. 123 - Telp 0800-000-000</div>
    </div>

    <div class="row"><span>No. Struk</span><span>#{{ $transaksi->idtransaksi }}</span></div>
    <div class="row"><span>Tanggal</span><span>{{ optional($transaksi->created_at)->format('d/m/Y H:i') }}</span></div>
    <div class="row"><span>Kasir</span><span>{{ optional($transaksi->kasir)->name ?? '-' }}</span></div>
    <div class="row"><span>Meja</span><span>{{ optional($transaksi->pesanan->meja)->nomormeja ?? '-' }}</span></div>
    <div class="row"><span>Pelanggan</span><span>{{ optional($transaksi->pesanan->pelanggan)->namapelanggan ?? '-' }}</span></div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->pesanan->detail as $item)
            <tr>
                <td>{{ optional($item->menu)->namamenu ?? '-' }}</td>
                <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3">Bayar</td>
                <td>Rp {{ number_format($transaksi->bayar ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3">Kembali</td>
                <td>Rp {{ number_format($transaksi->kembali ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3">Metode</td>
                <td>{{ strtoupper($transaksi->metode_pembayaran ?? '-') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="muted" style="margin-top:12px; text-align:center;">Terima kasih dan selamat menikmati</div>

    <script>
        window.onload = function(){ window.print(); };
    </script>
</body>
</html>

