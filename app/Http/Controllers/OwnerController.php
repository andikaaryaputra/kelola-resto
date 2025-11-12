<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    // Dashboard owner
    public function index()
    {
        $today = now()->format('Y-m-d');

        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('total');
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();

        $totalMeja = Meja::count();
        $mejaKosong = Meja::where('status', 'kosong')->count();
        $mejaTerisi = Meja::where('status', 'terisi')->count();
        $mejaMaintenance = Meja::where('status', 'maintenance')->count();

        $totalMenu = Menu::count();

        // Data untuk grafik 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenue = Transaksi::whereDate('created_at', $date)->sum('total');
            $chartData[] = [
                'date' => now()->subDays($i)->format('d/m'),
                'revenue' => $revenue,
            ];
        }

        // Status pesanan hari ini (untuk pie chart)
        $statusToday = [
            'pending' => Pesanan::whereDate('created_at', $today)->where('status', 'pending')->count(),
            'proses' => Pesanan::whereDate('created_at', $today)->where('status', 'proses')->count(),
            'selesai' => Pesanan::whereDate('created_at', $today)->where('status', 'selesai')->count(),
            'lunas' => Pesanan::whereDate('created_at', $today)->where('status', 'lunas')->count(),
        ];

        return view('owner.dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalMeja',
            'mejaKosong',
            'mejaTerisi',
            'mejaMaintenance',
            'totalMenu',
            'chartData',
            'statusToday'
        ));
    }

    // Laporan Owner (pakai Stored Procedure)
    public function laporan(Request $request)
    {
        // Default tanggal hari ini
        $tanggal = $request->input('tanggal', now()->toDateString());

        // Panggil stored procedure
        $transaksi = DB::select('CALL LaporanTransaksiHarian(?)', [$tanggal]);

        // Hitung total omset dari hasil stored procedure
        $totalOmset = collect($transaksi)->sum('total');

        return view('owner.laporan', compact('tanggal', 'transaksi', 'totalOmset'));
    }

    // Cetak laporan Owner
    public function laporanPrint(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        // Panggil stored procedure lagi untuk versi cetak
        $transaksi = DB::select('CALL LaporanTransaksiHarian(?)', [$tanggal]);
        $totalOmset = collect($transaksi)->sum('total');

        return view('owner.laporan.print', compact('tanggal', 'transaksi', 'totalOmset'));
    }
}
