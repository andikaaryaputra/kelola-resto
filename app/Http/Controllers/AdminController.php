<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    public function index()
    {
        $totalMeja = Meja::count();
        $mejaKosong = Meja::where('status', 'kosong')->count();
        $mejaTerisi = Meja::where('status', 'terisi')->count();
        $totalMenu = Menu::count();

        return view('admin.dashboard', compact('totalMeja', 'mejaKosong', 'mejaTerisi', 'totalMenu'));
    }

    // Tambah meja baru
    public function store(Request $request)
    {
        $meja = Meja::create([
            'nomormeja' => $request->nomormeja,
            'kapasitas' => $request->kapasitas,
            'status' => 'kosong'
        ]);

        return response()->json($meja, 201);
    }

    // Update meja
    public function update(Request $request, $id)
    {
        $meja = Meja::find($id);
        $meja->update($request->all());
        return response()->json($meja);
    }

    // Hapus meja
    public function destroy($id)
    {
        Meja::find($id)->delete();
        return response()->json(['message' => 'Meja dihapus']);
    }
}
