<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pesanan.meja', 'pesanan.pelanggan', 'kasir'])->get();
        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pesanans = Pesanan::where('status', 'selesai')
            ->whereDoesntHave('transaksi')
            ->with(['meja', 'pelanggan'])
            ->get();
        return view('kasir.transaksi.create', compact('pesanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanans,idpesanan',
            'bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,card,transfer',
        ]);

        $pesanan = Pesanan::findOrFail($request->idpesanan);
        $kembali = $request->bayar - $pesanan->total;

        if ($kembali < 0) {
            return back()->withErrors(['bayar' => 'Jumlah pembayaran kurang dari total pesanan']);
        }

        $transaksi = Transaksi::create([
            'idpesanan' => $request->idpesanan,
            'idkasir' => auth()->id(),
            'total' => $pesanan->total,
            'bayar' => $request->bayar,
            'kembali' => $kembali,
            'metode_pembayaran' => $request->metode_pembayaran
        ]);

        return redirect()->route('kasir.transaksi.index')->with('success', 'Transaksi berhasil diproses');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pesanan.meja', 'pesanan.pelanggan', 'pesanan.detail.menu', 'kasir'])->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function print($id)
    {
        $transaksi = Transaksi::with(['pesanan.meja', 'pesanan.pelanggan', 'pesanan.detail.menu', 'kasir'])->findOrFail($id);
        return view('kasir.transaksi.print', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('kasir.transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}