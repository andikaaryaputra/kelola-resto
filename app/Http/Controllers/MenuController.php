<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namamenu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
        ]);

        Menu::create([
            'namamenu' => $request->namamenu,
            'harga' => $request->harga,
            'aktif' => true
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::where('idmenu', $id)->firstOrFail();
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namamenu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'aktif' => 'boolean',
        ]);

        $menu = Menu::where('idmenu', $id)->firstOrFail();
        $menu->update($request->all());

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }
}