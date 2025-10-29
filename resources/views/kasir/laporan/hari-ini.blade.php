@extends('layouts.app')

@section('title', 'Laporan Hari Ini')
@section('page-title', 'Laporan Hari Ini')

@section('content')
<div class="space-y-6">
    <!-- Header dengan tombol print -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Laporan Transaksi</h2>
            <p class="text-gray-600 mt-1">Periode: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('kasir.hari-ini.print', ['from' => $from, 'to' => $to]) }}" target="_blank"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-print mr-2"></i>
                <span class="font-semibold">Cetak Laporan</span>
            </a>
            <a href="{{ route('kasir.dashboard') }}"
               class="bg-blue-200 hover:bg-blue-300 text-blue-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-semibold">Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('kasir.hari-ini') }}" class="flex items-center space-x-4">
            <div>
                <label for="from" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" id="from" name="from" value="{{ $from ?? now()->toDateString() }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="to" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" id="to" name="to" value="{{ $to ?? now()->toDateString() }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>
    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-sm text-gray-600">Total Pendapatan</div>
            <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-sm text-gray-600">Transaksi</div>
            <div class="text-3xl font-bold text-gray-900">{{ count($transaksi ?? []) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-sm text-gray-600">Metode</div>
            <div class="text-gray-900">Cash: {{ $paymentBreakdown['cash'] ?? 0 }}, Card: {{ $paymentBreakdown['card'] ?? 0 }}, QRIS: {{ $paymentBreakdown['qris'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Daftar Transaksi -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Hari Ini</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse(($transaksi ?? []) as $t)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $t->idtransaksi ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $t->idpesanan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format(($t->total ?? 0), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format(($t->bayar ?? 0), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format(($t->kembali ?? 0), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst(($t->metode_pembayaran ?? '-')) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($t->created_at)->format('H:i') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi hari ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


