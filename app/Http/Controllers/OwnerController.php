<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;

use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

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

        // Data untuk chart 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenue = Transaksi::whereDate('created_at', $date)->sum('total');
            $chartData[] = [
                'date' => now()->subDays($i)->format('d/m'),
                'revenue' => $revenue
            ];
        }

        // Breakdown status pesanan hari ini (untuk pie chart)
        $statusToday = [
            'pending' => Pesanan::whereDate('created_at', $today)->where('status', 'pending')->count(),
            'proses' => Pesanan::whereDate('created_at', $today)->where('status', 'proses')->count(),
            'selesai' => Pesanan::whereDate('created_at', $today)->where('status', 'selesai')->count(),
            'lunas' => Pesanan::whereDate('created_at', $today)->where('status', 'lunas')->count(),
        ];

        return view('owner.dashboard', compact('pendapatanHariIni', 'transaksiHariIni', 'totalMeja', 'mejaKosong', 'mejaTerisi', 'mejaMaintenance', 'totalMenu', 'chartData', 'statusToday'));
    }

    // Laporan owner
    public function laporan()
    {
        $from = request('from', now()->toDateString());
        $to = request('to', now()->toDateString());

        $transaksi = Transaksi::with(['pesanan.meja', 'kasir'])
            ->whereBetween('created_at', [now()->parse($from)->startOfDay(), now()->parse($to)->endOfDay()])
            ->orderByDesc('created_at')
            ->get();
        $totalOmset = (float) $transaksi->sum('total');

        return view('owner.laporan', compact('from','to','transaksi','totalOmset'));
    }

    // Cetak laporan owner (tabel saja)
    public function laporanPrint()
    {
        $from = request('from', request('date', now()->toDateString()));
        $to = request('to', request('date', now()->toDateString()));

        // Data transaksi pada rentang tanggal
        $transaksi = Transaksi::with(['pesanan.meja', 'kasir'])
            ->whereBetween('created_at', [now()->parse($from)->startOfDay(), now()->parse($to)->endOfDay()])
            ->orderByDesc('created_at')
            ->get();
        $totalOmset = (float) $transaksi->sum('total');

        // Data pesanan pada rentang tanggal
        $pesanans = Pesanan::with(['meja', 'pelanggan'])
            ->whereBetween('created_at', [now()->parse($from)->startOfDay(), now()->parse($to)->endOfDay()])
            ->orderByDesc('created_at')
            ->get();
        $totalPesananNominal = (float) $pesanans->sum('total');

        return view('owner.laporan.print', compact('from','to','transaksi','totalOmset','pesanans','totalPesananNominal'));
    }
}
