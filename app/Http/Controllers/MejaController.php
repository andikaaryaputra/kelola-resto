<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('admin.meja.index', compact('mejas'));
    }

    public function create()
    {
        return view('admin.meja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomormeja' => 'required|string|max:10',
            'kapasitas' => 'required|integer|min:1|max:20',
        ]);

        Meja::create([
            'nomormeja' => $request->nomormeja,
            'kapasitas' => $request->kapasitas,
            'status' => 'kosong'
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan');
    }

    public function edit(Meja $meja)
    {
        return view('admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomormeja' => 'required|string|max:10',
            'kapasitas' => 'required|integer|min:1|max:20',
            'status' => 'required|in:kosong,terisi,maintenance',
        ]);

        $meja->update($request->all());

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus');
    }
}