<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Meja;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class WaiterController extends Controller
{
    // Dashboard waiter (Sudah Cukup Baik)
    public function index()
    {
        $totalPesanan = Pesanan::count();
        $pesananPending = Pesanan::where('status', 'pending')->count();
        $pesananProses = Pesanan::where('status', 'proses')->count();
        $totalPelanggan = Pelanggan::count();
        $recentPesanan = Pesanan::with(['meja', 'pelanggan'])->latest()->take(5)->get();

        return view('waiter.dashboard', compact('totalPesanan', 'pesananPending', 'pesananProses', 'totalPelanggan', 'recentPesanan'));
    }

    // Laporan waiter (Sudah Cukup Baik)
    public function laporan(Request $request)
    {
        $from = $request->input('from', now()->toDateString());
        $to = $request->input('to', now()->toDateString());
        $startOfDay = now()->parse($from)->startOfDay();
        $endOfDay = now()->parse($to)->endOfDay();

        $query = Pesanan::whereBetween('created_at', [$startOfDay, $endOfDay]);

        // PERBAIKAN PERFORMA: Hitung total di database
        $total = (float) $query->sum('total');
        $pesanans = $query->with(['meja','pelanggan','detail'])->orderByDesc('created_at')->get();

        if ($request->routeIs('waiter.laporan.print') || $request->has('print')) {
            return view('waiter.laporan.print', compact('pesanans','total','from','to'));
        }

        return view('waiter.laporan.index', compact('pesanans','total','from','to'));
    }

    // --- PERBAIKAN PADA API ---

    // Kelola menu
    public function menu()
    {
        $menus = Menu::orderBy('namamenu')->get();
        return response()->json($menus);
    }

    public function storeMenu(Request $request)
    {
        // PERBAIKAN: Tambahkan validasi
        $validatedData = $request->validate([
            'namamenu' => 'required|string|max:100|unique:menu,namamenu',
            'harga' => 'required|numeric|min:0',
        ]);
        $validatedData['aktif'] = true;

        $menu = Menu::create($validatedData);
        return response()->json($menu, 201);
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id); // Gunakan findOrFail untuk 404 jika tidak ada

        // PERBAIKAN: Tambahkan validasi dan jangan gunakan $request->all()
        $validatedData = $request->validate([
            'namamenu' => ['required', 'string', 'max:100', Rule::unique('menu')->ignore($menu->idmenu, 'idmenu')],
            'harga' => 'required|numeric|min:0',
            'aktif' => 'required|boolean'
        ]);

        $menu->update($validatedData);
        return response()->json($menu);
    }

    // Kelola pesanan
    public function storePesanan(Request $request)
    {
        // PERBAIKAN: Validasi input secara menyeluruh
        $validatedData = $request->validate([
            'idmeja' => 'required|exists:meja,idmeja',
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|exists:menu,idmenu',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            // PERBAIKAN: Gunakan transaksi database
            $pesanan = DB::transaction(function () use ($validatedData, $request) {
                
                // PERBAIKAN: Hitung ulang total di server
                $menuIds = collect($validatedData['items'])->pluck('idmenu');
                $menusInDb = Menu::whereIn('idmenu', $menuIds)->get()->keyBy('idmenu');
                
                $total = collect($validatedData['items'])->sum(function ($item) use ($menusInDb) {
                    $menu = $menusInDb->get($item['idmenu']);
                    return $menu->harga * $item['jumlah'];
                });

                // Buat pesanan utama
                $pesanan = Pesanan::create([
                    'idmeja' => $validatedData['idmeja'],
                    'iduser_waiter' => Auth::id(),
                    'idpelanggan' => $validatedData['idpelanggan'],
                    'status' => 'pending',
                    'total' => $total, // Gunakan total yang dihitung di server
                ]);

                // Siapkan detail pesanan untuk insert massal
                $detailItems = collect($validatedData['items'])->map(function ($item) use ($menusInDb, $pesanan) {
                    $menu = $menusInDb->get($item['idmenu']);
                    return [
                        'idpesanan' => $pesanan->idpesanan,
                        'idmenu' => $item['idmenu'],
                        'jumlah' => $item['jumlah'],
                        'harga' => $menu->harga, // Gunakan harga dari database
                        'subtotal' => $menu->harga * $item['jumlah'], // Hitung subtotal di server
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->all();

                // PERBAIKAN: Gunakan satu query untuk insert semua detail
                PesananDetail::insert($detailItems);

                // Update status meja
                Meja::find($validatedData['idmeja'])->update(['status' => 'terisi']);

                return $pesanan;
            });

            return response()->json($pesanan->load('detail'), 201);

        } catch (Throwable $e) {
            return response()->json(['message' => 'Gagal membuat pesanan: ' . $e->getMessage()], 500);
        }
    }

    public function updatePesanan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // PERBAIKAN: Validasi input & hanya izinkan update status
        $validatedData = $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pesanan->update($validatedData);
        return response()->json($pesanan);
    }

    // Daftar meja kosong
    public function mejaKosong()
    {
        $mejas = Meja::where('status', 'kosong')->get();
        return response()->json($mejas);
    }
}