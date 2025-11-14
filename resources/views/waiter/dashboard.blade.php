@extends('layouts.app')

@section('title', 'Kasir Dashboard')
@section('page-title', 'Kasir Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome -->
    <div class="bg-white p-4 rounded-lg border">
        <h1 class="text-lg font-semibold">Selamat Datang, {{ Auth::user()->name }}</h1>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Transaksi Hari Ini</p>
            <p class="text-xl font-bold mt-1">{{ $transaksiHariIni ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Pendapatan Hari Ini</p>
            <p class="text-xl font-bold mt-1">
                Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Siap Bayar</p>
            <p class="text-xl font-bold mt-1">{{ $pesananSiapBayar ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Total Transaksi</p>
            <p class="text-xl font-bold mt-1">{{ $totalTransaksi ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="font-medium mb-4">Transaksi Terbaru</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left border">No</th>
                        <th class="px-3 py-2 text-left border">Pesanan</th>
                        <th class="px-3 py-2 text-left border">Total</th>
                        <th class="px-3 py-2 text-left border">Bayar</th>
                        <th class="px-3 py-2 text-left border">Kembali</th>
                        <th class="px-3 py-2 text-left border">Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransaksi ?? [] as $transaksi)
                    <tr>
                        <td class="border px-3 py-2">#{{ $transaksi->idtransaksi }}</td>
                        <td class="border px-3 py-2">#{{ $transaksi->idpesanan }}</td>
                        <td class="border px-3 py-2">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 border">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
