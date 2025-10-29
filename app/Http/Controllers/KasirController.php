<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    // Dashboard kasir
    public function index()
    {
        $start = now()->startOfDay();
        $end = now()->endOfDay();
        $transaksiHariIni = Transaksi::whereBetween('created_at', [$start, $end])->count();
        $pendapatanHariIni = (float) Transaksi::whereBetween('created_at', [$start, $end])->sum('total');
        $pesananSiapBayar = Pesanan::where('status', 'selesai')->whereDoesntHave('transaksi')->count();
        $totalTransaksi = Transaksi::count();
        $recentTransaksi = Transaksi::latest()->take(5)->get();

        // Chart: 7 hari terakhir (pendapatan)
        $kasirChart7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $dayStart = now()->subDays($i)->startOfDay();
            $dayEnd = now()->subDays($i)->endOfDay();
            $revenue = (float) Transaksi::whereBetween('created_at', [$dayStart, $dayEnd])->sum('total');
            $kasirChart7Hari[] = [
                'date' => $dayStart->format('d/m'),
                'revenue' => (float) $revenue,
            ];
        }

        // Chart: distribusi metode pembayaran (hari ini)
        $paymentMethods = ['cash', 'card', 'qris'];
        $paymentBreakdown = [];
        foreach ($paymentMethods as $method) {
            $paymentBreakdown[$method] = Transaksi::whereBetween('created_at', [$start, $end])
                ->where('metode_pembayaran', $method)
                ->count();
        }

        return view('kasir.dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'pesananSiapBayar',
            'totalTransaksi',
            'recentTransaksi',
            'kasirChart7Hari',
            'paymentBreakdown'
        ));
    }

    // Proses pembayaran
    public function store(Request $request)
    {
        $transaksi = Transaksi::create([
            'idpesanan' => $request->idpesanan,
            'idkasir' => auth()->id(),
            'total' => $request->total,
            'bayar' => $request->bayar,
            'kembali' => $request->bayar - $request->total,
            'metode_pembayaran' => $request->metode_pembayaran
        ]);

        // Update status pesanan jadi lunas
        Pesanan::find($request->idpesanan)->update(['status' => 'lunas']);

        // Bebaskan meja
        $pesanan = Pesanan::find($request->idpesanan);
        $pesanan->meja->update(['status' => 'kosong']);

        return response()->json($transaksi, 201);
    }

    // Daftar pesanan siap bayar
    public function pesananSiapBayar()
    {
        $pesanan = Pesanan::with(['meja', 'detail.menu', 'pelanggan'])
            ->where('status', 'selesai')
            ->whereDoesntHave('transaksi')
            ->get();
        return view('kasir.siap-bayar', compact('pesanan'));
    }

    // Laporan transaksi dengan rentang tanggal
    public function hariIni()
    {
        $from = request('from', now()->toDateString());
        $to = request('to', now()->toDateString());

        $transaksi = Transaksi::with(['pesanan.meja', 'kasir'])
            ->whereBetween('created_at', [\Carbon\Carbon::parse($from)->startOfDay(), \Carbon\Carbon::parse($to)->endOfDay()])
            ->latest()
            ->get();
        $total = (float) $transaksi->sum('total');

        // Breakdown metode pembayaran
        $paymentMethods = ['cash', 'card', 'qris'];
        $paymentBreakdown = [];
        foreach ($paymentMethods as $method) {
            $paymentBreakdown[$method] = Transaksi::whereBetween('created_at', [\Carbon\Carbon::parse($from)->startOfDay(), \Carbon\Carbon::parse($to)->endOfDay()])
                ->where('metode_pembayaran', $method)
                ->count();
        }

        // Check if this is a print request
        if (request()->routeIs('kasir.hari-ini.print') || request('print')) {
            return view('kasir.laporan.print', [
                'transaksi' => $transaksi,
                'total' => $total,
                'paymentBreakdown' => $paymentBreakdown,
                'from' => $from,
                'to' => $to,
            ]);
        }

        return view('kasir.laporan.hari-ini', [
            'transaksi' => $transaksi,
            'total' => $total,
            'paymentBreakdown' => $paymentBreakdown,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
