@extends('layouts.app')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="space-y-4">

    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Daftar Pesanan</h2>
        <a href="{{ route('waiter.pesanan.create') }}" class="bg-blue-600 text-white px-3 py-1.5 rounded">
            + Pesanan
        </a>
    </div>

    <div class="bg-white border rounded">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left">Meja</th>
                        <th class="px-4 py-2 text-left">Pelanggan</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Dibuat</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pesanans as $pesanan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $pesanan->meja->nomormeja ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ ucfirst($pesanan->status) }}
                        </td>
                        <td class="px-4 py-2">
                            Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $pesanan->created_at->format('d/m/Y') }}
                        </td>

                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('waiter.pesanan.edit', $pesanan->idpesanan) }}" class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('waiter.pesanan.destroy', $pesanan->idpesanan) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Hapus pesanan ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                            Belum ada pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
