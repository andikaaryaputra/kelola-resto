<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Tampilkan semua pelanggan
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('waiter.pelanggan.index', compact('pelanggans'));
    }

    // Tampilkan form tambah pelanggan
    public function create()
    {
        return view('waiter.pelanggan.create');
    }

    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $pelanggan = Pelanggan::create([
            'namapelanggan' => $request->namapelanggan,
            'jeniskelamin' => $request->jeniskelamin,
            'noip' => $request->noip,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('waiter.pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // Tampilkan form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('waiter.pelanggan.edit', compact('pelanggan'));
    }

    // Update pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('waiter.pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // Hapus pelanggan
    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();
        return redirect()->route('waiter.pelanggan.index')->with('success', 'Pelanggan dihapus!');
    }
}
