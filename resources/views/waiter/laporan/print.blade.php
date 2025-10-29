<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Waiter - {{ (isset($from)&&isset($to)) ? (\Carbon\Carbon::parse($from)->format('d/m/Y').' - '.\Carbon\Carbon::parse($to)->format('d/m/Y')) : now()->format('d/m/Y') }}</title>
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
            padding: 30px;
            color: #1f2937; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        
        .header { 
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(30deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(30deg); }
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header h1 { 
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .header .subtitle {
            font-size: 18px;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .header .date {
            font-size: 16px;
            font-weight: 500;
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .content {
            padding: 40px;
        }
        
        .summary { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .summary-item { 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .summary-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc);
        }
        
        .summary-item .number { 
            font-size: 28px; 
            font-weight: 700; 
            color: #7c3aed;
            margin-bottom: 8px;
        }
        
        .summary-item .label { 
            font-size: 14px; 
            color: #6b7280; 
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section {
            margin: 40px 0;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #7c3aed;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #a855f7, #c084fc);
        }
        
        .chart-bars { 
            display: flex; 
            align-items: end; 
            height: 200px; 
            border-bottom: 2px solid #e5e7eb; 
            padding-bottom: 20px;
            margin: 30px 0;
        }
        
        .chart-bar { 
            flex: 1; 
            margin: 0 8px; 
            background: linear-gradient(to top, #7c3aed, #a855f7); 
            border-radius: 8px 8px 0 0; 
            position: relative; 
            min-height: 20px;
            box-shadow: 0 4px 6px -1px rgba(124, 58, 237, 0.3);
        }
        
        .chart-bar .value { 
            position: absolute; 
            top: -25px; 
            left: 50%; 
            transform: translateX(-50%); 
            font-size: 14px; 
            font-weight: 700;
            color: #7c3aed;
        }
        
        .chart-bar .date { 
            position: absolute; 
            bottom: -30px; 
            left: 50%; 
            transform: translateX(-50%); 
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 30px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        th { 
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            color: white;
            padding: 16px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td { 
            padding: 16px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        
        tr:nth-child(even) {
            background: #f9fafb;
        }
        
        tr:hover {
            background: #f3f4f6;
        }
        
        .footer { 
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 40px;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .footer .main-text {
            font-size: 16px;
            font-weight: 600;
        }
        
        @media print {
            body { 
                margin: 0;
                padding: 20px;
                background: white;
            }
            .container {
                box-shadow: none;
                border-radius: 0;
            }
            .header::before {
                display: none;
            }
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>Laporan Pesanan Waiter</h1>
                <div class="subtitle">Restaurant Cashier System</div>
                <div class="date">{{ \Carbon\Carbon::parse($from)->format('d F Y') }} - {{ \Carbon\Carbon::parse($to)->format('d F Y') }}</div>
            </div>
        </div>
        
        <div class="content">
            <div class="section">
                <div class="section-title">Tabel Pesanan</div>
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
                                <td colspan="5" style="text-align: center; padding: 40px; color: #6b7280;">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align:right;">Total Omset</th>
                            <th>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="footer">
            <p class="main-text">Restaurant Cashier System</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Dicetak oleh: {{ auth()->user()->name ?? 'Waiter' }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 1000);
        }
    </script>
</body>
</html>
