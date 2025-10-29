@extends('layouts.app')

@section('title', 'Laporan Waiter')
@section('page-title', 'Laporan Waiter')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Laporan Pesanan Waiter</h2>
            <p class="text-gray-600 mt-1">Periode: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('waiter.laporan.print', ['from' => $from, 'to' => $to]) }}" target="_blank"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-print mr-2"></i>
                <span class="font-semibold">Cetak Laporan</span>
            </a>
            <a href="{{ route('waiter.dashboard') }}"
               class="bg-blue-200 hover:bg-blue-300 text-blue-700 px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-semibold">Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('waiter.laporan') }}" class="flex items-center space-x-4">
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

    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pesanans as $p)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($p->created_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($p->meja)->nomormeja ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($p->pelanggan)->namapelanggan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($p->status==='pending') bg-yellow-100 text-yellow-800
                                @elseif($p->status==='proses') bg-blue-100 text-blue-800
                                @elseif($p->status==='selesai') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">{{ ucfirst($p->status) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Total Omset</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection


