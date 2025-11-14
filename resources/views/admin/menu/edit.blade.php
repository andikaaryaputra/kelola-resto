@extends('layouts.app')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')

<div class="max-w-2xl mx-auto">

    <h2 class="text-xl font-semibold mb-4">Edit Menu: {{ $menu->namamenu }}</h2>

    <div class="bg-white p-4 border rounded">

        <form action="{{ route('admin.menu.update', $menu->idmenu) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="namamenu" class="block mb-1">Nama Menu</label>
                <input type="text"
                    id="namamenu"
                    name="namamenu"
                    value="{{ old('namamenu', $menu->namamenu) }}"
                    class="w-full border px-3 py-2 rounded"
                    required>
            </div>

            <div class="mb-4">
                <label for="harga" class="block mb-1">Harga</label>
                <input type="number"
                    id="harga"
                    name="harga"
                    value="{{ old('harga', $menu->harga) }}"
                    class="w-full border px-3 py-2 rounded"
                    min="0"
                    required>
            </div>

            <div class="mb-4">
                <label for="aktif" class="block mb-1">Status Menu</label>
                <select name="aktif" id="aktif" class="w-full border px-3 py-2 rounded">
                    <option value="1" {{ old('aktif', $menu->aktif) ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !old('aktif', $menu->aktif) ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                    Update Menu
                </button>

                <a href="{{ route('admin.menu.index') }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded w-full text-center">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
