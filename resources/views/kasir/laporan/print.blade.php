<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasir - {{ (isset($from)&&isset($to)) ? (\Carbon\Carbon::parse($from)->format('d/m/Y').' - '.\Carbon\Carbon::parse($to)->format('d/m/Y')) : now()->format('d/m/Y') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Inter', Arial, sans-serif; 
            margin: 0;
            padding: 20px;
            color: #1f2937; 
            background: white;
        }
        
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 20px; 
        }
        
        .header h1 { 
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p { 
            margin: 5px 0; 
            color: #666; 
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0;
            background: white;
        }
        
        th { 
            background: #f8f9fa;
            color: #333;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #ddd;
        }
        
        td { 
            padding: 12px 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        
        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 12px; 
            color: #666; 
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        @media print {
            body { 
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Transaksi Kasir</h1>
        <p>Restaurant Cashier System</p>
        <p>Periode: {{ \Carbon\Carbon::parse($from)->format('d F Y') }} - {{ \Carbon\Carbon::parse($to)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Pesanan</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembali</th>
                <th>Metode</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($transaksi ?? []) as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>#{{ $t->idtransaksi ?? '-' }}</td>
                    <td>#{{ $t->idpesanan ?? '-' }}</td>
                    <td>Rp {{ number_format(($t->total ?? 0), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($t->bayar ?? 0), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($t->kembali ?? 0), 0, ',', '.') }}</td>
                    <td>{{ ucfirst(($t->metode_pembayaran ?? '-')) }}</td>
                    <td>{{ optional($t->created_at)->format('H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #6b7280;">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Restaurant Cashier System</p>
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
