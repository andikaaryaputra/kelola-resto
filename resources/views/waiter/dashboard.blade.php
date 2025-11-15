@extends('layouts.app')

@section('title', 'Waiter Dashboard')
@section('page-title', 'Waiter Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome -->
    <div class="bg-white p-4 rounded-lg border">
        <h1 class="text-lg font-semibold">Selamat Datang, {{ Auth::user()->name }}</h1>
    </div>

    <!-- Stats untuk Waiter -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Total Pesanan</p>
            <p class="text-xl font-bold mt-1">{{ $totalPesanan ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Pesanan Pending</p>
            <p class="text-xl font-bold mt-1">{{ $pesananPending ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Pesanan Diproses</p>
            <p class="text-xl font-bold mt-1">{{ $pesananProses ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Total Pelanggan</p>
            <p class="text-xl font-bold mt-1">{{ $totalPelanggan ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Pesanan -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="font-medium mb-4">Pesanan Terbaru</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left border">ID Pesanan</th>
                        <th class="px-3 py-2 text-left border">Meja</th>
                        <th class="px-3 py-2 text-left border">Pelanggan</th>
                        <th class="px-3 py-2 text-left border">Total</th>
                        <th class="px-3 py-2 text-left border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPesanan ?? [] as $pesanan)
                    <tr>
                        <td class="border px-3 py-2">#{{ $pesanan->idpesanan }}</td>

                        <!-- FIXED: kini memakai nomormeja -->
                        <td class="border px-3 py-2">{{ $pesanan->meja->nomormeja ?? 'N/A' }}</td>

                        <td class="border px-3 py-2">{{ $pesanan->pelanggan->namapelanggan ?? 'N/A' }}</td>

                        <td class="border px-3 py-2">
                            Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                        </td>

                        <td class="border px-3 py-2">{{ ucfirst($pesanan->status) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500 border">
                            Belum ada pesanan terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
