<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Meja;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    // Dashboard waiter
    public function index()
    {
        $totalPesanan = Pesanan::count();
        $pesananPending = Pesanan::where('status', 'pending')->count();
        $pesananProses = Pesanan::where('status', 'proses')->count();
        $totalPelanggan = Pelanggan::count();
        $recentPesanan = Pesanan::with(['meja', 'pelanggan'])->latest()->take(5)->get();

        return view('waiter.dashboard', compact('totalPesanan', 'pesananPending', 'pesananProses', 'totalPelanggan', 'recentPesanan'));
    }

    // Laporan waiter (tabel + rentang tanggal)
    public function laporan()
    {
        $from = request('from', now()->toDateString());
        $to = request('to', now()->toDateString());

        $pesanans = Pesanan::with(['meja','pelanggan','detail'])
            ->whereBetween('created_at', [now()->parse($from)->startOfDay(), now()->parse($to)->endOfDay()])
            ->orderByDesc('created_at')
            ->get();

        $total = (float) $pesanans->sum('total');

        if (request()->routeIs('waiter.laporan.print') || request('print')) {
            return view('waiter.laporan.print', compact('pesanans','total','from','to'));
        }

        return view('waiter.laporan.index', compact('pesanans','total','from','to'));
    }

    // Kelola menu
    public function menu()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    public function storeMenu(Request $request)
    {
        $menu = Menu::create([
            'namamenu' => $request->namamenu,
            'harga' => $request->harga,
            'aktif' => true
        ]);
        return response()->json($menu, 201);
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->update($request->all());
        return response()->json($menu);
    }

    // Kelola pesanan
    public function storePesanan(Request $request)
    {
        $pesanan = Pesanan::create([
            'idmeja' => $request->idmeja,
            'iduser_waiter' => auth()->id(),
            'idpelanggan' => $request->idpelanggan,
            'status' => 'pending',
            'total' => $request->total
        ]);

        // Tambah detail pesanan
        foreach ($request->items as $item) {
            PesananDetail::create([
                'idpesanan' => $pesanan->idpesanan,
                'idmenu' => $item['idmenu'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['subtotal']
            ]);
        }

        // Update status meja
        Meja::find($request->idmeja)->update(['status' => 'terisi']);

        return response()->json($pesanan, 201);
    }

    public function updatePesanan(Request $request, $id)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->update($request->all());
        return response()->json($pesanan);
    }

    // Daftar meja kosong
    public function mejaKosong()
    {
        $mejas = Meja::where('status', 'kosong')->get();
        return response()->json($mejas);
    }
}
