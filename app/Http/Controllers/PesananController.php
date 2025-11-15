<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Meja;
use App\Models\Pelanggan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['meja', 'pelanggan', 'detail.menu'])
            ->latest() // Menampilkan yang terbaru di atas
            ->get();
        return view('waiter.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan form untuk membuat pesanan baru.
     */
    public function create()
    {
        $mejas = Meja::where('status', 'kosong')->get();
        $menus = Menu::where('aktif', true)->orderBy('namamenu')->get();
        return view('waiter.pesanan.create', compact('mejas', 'menus'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idmeja' => 'required|exists:mejas,idmeja',
            'namapelanggan' => 'required|string|max:100',
            'menus' => 'required|array|min:1',
            'menus.*.idmenu' => 'required|exists:menus,idmenu',
            'menus.*.jumlah' => 'required|integer|min:1', // Diubah ke min:1 karena yang 0 tidak perlu dikirim
        ]);

        try {
            // Memulai transaksi database untuk memastikan konsistensi data
            $pesanan = DB::transaction(function () use ($request) {

                // --- 1. Ambil Data Menu (Solusi N+1 Query Problem) ---
                $validMenusData = collect($request->menus)->filter(fn($menu) => $menu['jumlah'] > 0);
                $menuIds = $validMenusData->pluck('idmenu');
                $menusInDb = Menu::whereIn('idmenu', $menuIds)->get()->keyBy('idmenu');

                // --- 2. Hitung Total Harga ---
                $total = $validMenusData->sum(function ($menuData) use ($menusInDb) {
                    $menu = $menusInDb->get($menuData['idmenu']);
                    return $menu->harga * $menuData['jumlah'];
                });

                if ($total <= 0) {
                    throw new \Exception("Total pesanan tidak valid.");
                }

                // --- 3. Buat atau Cari Pelanggan (Cara Eloquent) ---
                $pelanggan = Pelanggan::firstOrCreate(
                    ['namapelanggan' => $request->namapelanggan],
                    ['jeniskelamin' => true, 'noip' => '-', 'alamat' => '-']
                );

                // --- 4. Buat Pesanan Utama ---
                $pesanan = Pesanan::create([
                    'idmeja' => $request->idmeja,
                    'iduser_waiter' => Auth::id(),
                    'idpelanggan' => $pelanggan->idpelanggan,
                    'status' => 'pending',
                    'total' => $total
                ]);

                // --- 5. Siapkan dan Buat Detail Pesanan (Menggunakan createMany) ---
                $detailItems = $validMenusData->map(function ($menuData) use ($menusInDb) {
                    $menu = $menusInDb->get($menuData['idmenu']);
                    return [
                        'idmenu' => $menuData['idmenu'],
                        'jumlah' => $menuData['jumlah'],
                        'harga' => $menu->harga,
                        'subtotal' => $menu->harga * $menuData['jumlah'],
                        'status_item' => 'ORDERED'
                    ];
                })->values()->all();

                $pesanan->detail()->createMany($detailItems);

                // --- 6. Update Status Meja ---
                Meja::find($request->idmeja)->update(['status' => 'terisi']);

                return $pesanan;
            });

        } catch (Throwable $e) {
            // Jika terjadi error, batalkan semua operasi dan kembalikan pesan error
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('waiter.pesanan.index')->with('success', 'Pesanan #' . $pesanan->idpesanan . ' berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit pesanan.
     */
    public function edit(Pesanan $pesanan)
    {
        $pesanan->load(['meja', 'pelanggan', 'detail.menu']);

        // --- PERBAIKAN: Hanya tampilkan meja yang kosong atau meja saat ini ---
        $mejas = Meja::where('status', 'kosong')
                     ->orWhere('idmeja', $pesanan->idmeja)
                     ->get();

        $pelanggans = Pelanggan::all();
        $menus = Menu::where('aktif', true)->get();
        return view('waiter.pesanan.edit', compact('pesanan', 'mejas', 'pelanggans', 'menus'));
    }

    /**
     * Mengupdate status pesanan.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pesanan->update(['status' => $request->status]);

        // --- KESALAHAN LOGIKA DIHAPUS ---
        // Meja HANYA BOLEH kembali kosong setelah pembayaran di kasir, BUKAN saat pesanan selesai diantar.
        // Menghapus blok ini mencegah meja kosong terlalu cepat.
        // if ($request->status === 'selesai') {
        //     $pesanan->meja->update(['status' => 'kosong']);
        // }

        return redirect()->route('waiter.pesanan.index')->with('success', 'Status pesanan #' . $pesanan->idpesanan . ' berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan.
     */
    public function destroy(Pesanan $pesanan)
    {
        DB::transaction(function () use ($pesanan) {
            // Menggunakan optional() untuk mencegah error jika pesanan tidak memiliki meja (data lama)
            optional($pesanan->meja)->update(['status' => 'kosong']);
            
            // Hapus detail pesanan terlebih dahulu (jika ada foreign key constraint)
            $pesanan->detail()->delete();
            $pesanan->delete();
        });

        return redirect()->route('waiter.pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}