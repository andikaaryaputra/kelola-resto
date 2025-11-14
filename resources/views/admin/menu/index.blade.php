@extends('layouts.app')

@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Daftar Menu</h2>
        <a href="{{ route('admin.menu.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">
            Tambah Menu
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow">

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="text-left p-2">Menu</th>
                    <th class="text-left p-2">Harga</th>
                    <th class="text-left p-2">Status</th>
                    <th class="text-left p-2">Dibuat</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($menus as $menu)
                <tr class="border-b">
                    <td class="p-2">{{ $menu->namamenu }}</td>

                    <td class="p-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>

                    <td class="p-2">
                        {{ $menu->aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </td>

                    <td class="p-2">
                        {{ $menu->created_at->format('d/m/Y') }}
                    </td>

                    <td class="p-2">
                        <a href="{{ route('admin.menu.edit', $menu->idmenu) }}" class="text-blue-600">
                            Edit
                        </a>

                        <form action="{{ route('admin.menu.destroy', $menu->idmenu) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Yakin ingin menghapus menu ini?')" class="text-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Belum ada menu ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
