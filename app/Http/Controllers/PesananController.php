<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Meja;
use App\Models\Pelanggan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['meja', 'pelanggan', 'detail.menu'])->get();
        return view('waiter.pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $mejas = Meja::where('status', 'kosong')->get();
        $menus = Menu::where('aktif', true)->get();
        return view('waiter.pesanan.create', compact('mejas', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idmeja' => 'required|exists:mejas,idmeja',
            'namapelanggan' => 'required|string|max:100',
            'menus' => 'required|array|min:1',
            'menus.*.idmenu' => 'required|exists:menus,idmenu',
            'menus.*.jumlah' => 'required|integer|min:0',
        ]);

        // Pastikan ada setidaknya satu item dengan jumlah > 0
        $hasAtLeastOneItem = false;
        foreach ($request->menus as $menuData) {
            if ((int)($menuData['jumlah'] ?? 0) > 0) {
                $hasAtLeastOneItem = true;
                break;
            }
        }
        if (!$hasAtLeastOneItem) {
            return back()->withErrors(['menus' => 'Tambahkan minimal 1 menu dengan jumlah lebih dari 0.'])->withInput();
        }

        // Buat atau cari pelanggan (toleran terhadap kolom wajib seperti 'noip'/'nohp')
        $pelangganId = DB::table('pelanggan')
            ->where('namapelanggan', $request->namapelanggan)
            ->value('idpelanggan');

        if (!$pelangganId) {
            $now = now();
            $pelangganId = DB::table('pelanggan')->insertGetId([
                'namapelanggan' => $request->namapelanggan,
                'jeniskelamin' => true,
                // Kolom opsional/kemungkinan wajib di DB
                'noip' => '-',
                'alamat' => '-',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Hitung total
        $total = 0;
        foreach ($request->menus as $menuData) {
            if ($menuData['jumlah'] > 0) {
                $menu = Menu::find($menuData['idmenu']);
                $total += $menu->harga * $menuData['jumlah'];
            }
        }

        if ($total <= 0) {
            return back()->withErrors(['menus' => 'Total pesanan tidak valid.'])->withInput();
        }

        // Buat pesanan
        $pesanan = Pesanan::create([
            'idmeja' => $request->idmeja,
            'iduser_waiter' => auth()->id(),
            'idpelanggan' => $pelangganId,
            'status' => 'pending',
            'total' => $total
        ]);

        // Buat detail pesanan
        foreach ($request->menus as $menuData) {
            if ($menuData['jumlah'] > 0) {
                $menu = Menu::find($menuData['idmenu']);
                $pesanan->detail()->create([
                    'idmenu' => $menuData['idmenu'],
                    'jumlah' => $menuData['jumlah'],
                    'harga' => $menu->harga,
                    'subtotal' => $menu->harga * $menuData['jumlah'],
                    'status_item' => 'ORDERED'
                ]);
            }
        }

        // Update status meja
        $meja = Meja::find($request->idmeja);
        $meja->update(['status' => 'terisi']);

        return redirect()->route('waiter.pesanan.index')->with('success', 'Pesanan berhasil dibuat');
    }

    public function edit(Pesanan $pesanan)
    {
        $pesanan->load(['meja', 'pelanggan', 'detail.menu']);
        $mejas = Meja::all();
        $pelanggans = Pelanggan::all();
        $menus = Menu::where('aktif', true)->get();
        return view('waiter.pesanan.edit', compact('pesanan', 'mejas', 'pelanggans', 'menus'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pesanan->update(['status' => $request->status]);

        // Jika status selesai, kembalikan meja ke kosong
        if ($request->status === 'selesai') {
            $pesanan->meja->update(['status' => 'kosong']);
        }

        return redirect()->route('waiter.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy(Pesanan $pesanan)
    {
        // Kembalikan meja ke kosong
        $pesanan->meja->update(['status' => 'kosong']);
        
        $pesanan->delete();

        return redirect()->route('waiter.pesanan.index')->with('success', 'Pesanan berhasil dihapus');
    }
}