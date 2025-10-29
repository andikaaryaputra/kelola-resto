<?php

namespace App\Http\Controllers;

use App\Models\PesananDetail;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Http\Request;

class PesananDetailController extends Controller
{
    public function index()
    {
        $details = PesananDetail::with(['pesanan', 'menu'])->get();
        return view('waiter.pesanan-detail.index', compact('details'));
    }

    public function create()
    {
        $pesanans = Pesanan::all();
        $menus = Menu::where('aktif', true)->get();
        return view('waiter.pesanan-detail.create', compact('pesanans', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanans,idpesanan',
            'idmenu' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $menu = Menu::find($request->idmenu);
        $subtotal = $menu->harga * $request->jumlah;

        PesananDetail::create([
            'idpesanan' => $request->idpesanan,
            'idmenu' => $request->idmenu,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal
        ]);

        // Update total pesanan
        $pesanan = Pesanan::find($request->idpesanan);
        $total = $pesanan->detail()->sum('subtotal');
        $pesanan->update(['total' => $total]);

        return redirect()->route('waiter.pesanan-detail.index')->with('success', 'Detail pesanan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $detail = PesananDetail::with(['pesanan', 'menu'])->findOrFail($id);
        $pesanans = Pesanan::all();
        $menus = Menu::where('aktif', true)->get();
        return view('waiter.pesanan-detail.edit', compact('detail', 'pesanans', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanans,idpesanan',
            'idmenu' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $detail = PesananDetail::findOrFail($id);
        $menu = Menu::find($request->idmenu);
        $subtotal = $menu->harga * $request->jumlah;

        $detail->update([
            'idpesanan' => $request->idpesanan,
            'idmenu' => $request->idmenu,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal
        ]);

        // Update total pesanan
        $pesanan = Pesanan::find($request->idpesanan);
        $total = $pesanan->detail()->sum('subtotal');
        $pesanan->update(['total' => $total]);

        return redirect()->route('waiter.pesanan-detail.index')->with('success', 'Detail pesanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $detail = PesananDetail::findOrFail($id);
        $pesananId = $detail->idpesanan;
        $detail->delete();

        // Update total pesanan
        $pesanan = Pesanan::find($pesananId);
        $total = $pesanan->detail()->sum('subtotal');
        $pesanan->update(['total' => $total]);

        return redirect()->route('waiter.pesanan-detail.index')->with('success', 'Detail pesanan berhasil dihapus');
    }
}