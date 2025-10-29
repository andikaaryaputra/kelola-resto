@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Transaksi #{{ $transaksi->idtransaksi }}</h2>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if($transaksi->metode_pembayaran==='cash') bg-green-100 text-green-800
                @elseif($transaksi->metode_pembayaran==='card') bg-blue-100 text-blue-800
                @else bg-purple-100 text-purple-800 @endif">
                {{ strtoupper($transaksi->metode_pembayaran) }}
            </span>
        </div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('kasir.transaksi.print', $transaksi->idtransaksi) }}" target="_blank" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm flex items-center">
                <i class="fas fa-print mr-2"></i> Cetak Struk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <div class="text-gray-600">Meja</div>
                <div class="text-gray-900 font-semibold">{{ $transaksi->pesanan->meja->nomormeja ?? '-' }}</div>
            </div>
            <div class="space-y-2">
                <div class="text-gray-600">Pelanggan</div>
                <div class="text-gray-900 font-semibold">{{ $transaksi->pesanan->pelanggan->namapelanggan ?? '-' }}</div>
            </div>
            <div class="space-y-2">
                <div class="text-gray-600">Total</div>
                <div class="text-gray-900 font-semibold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
            </div>
            <div class="space-y-2">
                <div class="text-gray-600">Bayar</div>
                <div class="text-gray-900 font-semibold">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</div>
            </div>
            <div class="space-y-2">
                <div class="text-gray-600">Kembali</div>
                <div class="text-gray-900 font-semibold">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</div>
            </div>
            <div class="space-y-2">
                <div class="text-gray-600">Tanggal</div>
                <div class="text-gray-900 font-semibold">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Rincian Pesanan</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transaksi->pesanan->detail as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->menu->namamenu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


