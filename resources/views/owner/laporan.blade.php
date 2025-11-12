@extends('layouts.app')

@section('title', 'Laporan Owner')
@section('page-title', 'Laporan Owner')

@section('content')
<div class="space-y-6">
    <!-- Header dengan tombol print -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Laporan Owner</h2>
            <p class="text-gray-600 mt-1">
                Transaksi restoran tanggal 
                {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('owner.laporan.print', ['tanggal' => $tanggal]) }}" target="_blank"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-print mr-2"></i>
                <span class="font-semibold">Cetak Laporan</span>
            </a>
            <a href="{{ route('owner.dashboard') }}"
               class="bg-blue-200 hover:bg-blue-300 text-blue-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-semibold">Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('owner.laporan') }}" class="flex items-center space-x-4">
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal ?? now()->toDateString() }}" 
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

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksi ?? [] as $t)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $t->idtransaksi ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $t->idpesanan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($t->bayar ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($t->kembali ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ strtoupper($t->metode_pembayaran ?? '-') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Total Omset</th>
                        <th colspan="4" class="px-6 py-3 text-left text-sm font-bold text-gray-900">
                            Rp {{ number_format($totalOmset ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
