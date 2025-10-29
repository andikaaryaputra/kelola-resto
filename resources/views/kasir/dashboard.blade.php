@extends('layouts.app')

@section('title', 'Kasir Dashboard')
@section('page-title', 'Kasir Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Selamat Datang, Kasir Restaurant!</h1>
                <p class="text-white text-lg">Kelola transaksi dan pembayaran dengan aman</p>
                <div class="mt-4 flex items-center space-x-4">
                    <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                        <span class="text-sm">User: {{ Auth::user()->name }}</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                        <span class="text-sm">{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-8xl opacity-20">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Transaksi Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $transaksiHariIni ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Pesanan Siap Bayar -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Siap Bayar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pesananSiapBayar ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTransaksi ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pendapatan 7 Hari Terakhir -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Pendapatan 7 Hari Terakhir</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @php
                    $maxRevenue = isset($kasirChart7Hari) ? max(array_map(fn($d) => $d['revenue'], $kasirChart7Hari)) : 0;
                @endphp
                @foreach(($kasirChart7Hari ?? []) as $data)
                    @php
                        $height = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 5;
                    @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-300 rounded-t transition-all duration-500 hover:from-green-600 hover:to-green-400"
                             style="height: {{ $height }}%; min-height: 20px;"
                             title="Rp {{ number_format($data['revenue'], 0, ',', '.') }}">
                        </div>
                        <div class="text-xs text-gray-500 mt-2">{{ $data['date'] }}</div>
                    <div class="text-xs text-gray-700 font-medium">Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Metode Pembayaran (Hari Ini) -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Metode Pembayaran (Hari Ini)</h3>
            <div class="h-64 flex items-center justify-center">
                @php
                    $pm = $paymentBreakdown ?? ['cash' => 0, 'card' => 0, 'qris' => 0];
                    $totalPm = max(1, ($pm['cash'] + $pm['card'] + $pm['qris']));
                    $cashPercent = ($pm['cash'] / $totalPm) * 100;
                    $cardPercent = ($pm['card'] / $totalPm) * 100;
                    $qrisPercent = 100 - $cashPercent - $cardPercent;
                @endphp
                <div class="relative w-48 h-48">
                    <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-green-500"
                         style="clip-path: polygon(50% 50%, 50% 0%, {{ 50 + sin(deg2rad($cashPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($cashPercent * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-blue-500"
                         style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad($cashPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($cashPercent * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($cashPercent + $cardPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($cashPercent + $cardPercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-purple-500"
                         style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad(($cashPercent + $cardPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($cashPercent + $cardPercent) * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($cashPercent + $cardPercent + $qrisPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($cashPercent + $cardPercent + $qrisPercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ ($pm['cash'] + $pm['card'] + $pm['qris']) }}</div>
                            <div class="text-sm text-gray-500">Total Pembayaran</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Cash</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $pm['cash'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Card</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $pm['card'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">QRIS</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $pm['qris'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Proses Pembayaran -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Proses Pembayaran</h3>
                <i class="fas fa-credit-card text-2xl text-green-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Proses pembayaran pesanan yang sudah selesai</p>
            <div class="space-y-3">
                <a href="{{ route('kasir.siap-bayar') }}" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-credit-card mr-2"></i>
                    Lihat Pesanan Siap Bayar
                </a>
                <a href="{{ route('kasir.transaksi.create') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Transaksi Baru
                </a>
            </div>
        </div>

        <!-- Laporan Transaksi -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Laporan Transaksi</h3>
                <i class="fas fa-chart-bar text-2xl text-blue-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Lihat laporan transaksi dan pendapatan</p>
            <div class="space-y-3">
                <a href="{{ route('kasir.hari-ini') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-calendar-day mr-2"></i>
                    Laporan Hari Ini
                </a>
                <a href="{{ route('kasir.hari-ini.print') }}" target="_blank" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Laporan
                </a>
                <a href="{{ route('kasir.transaksi.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-list mr-2"></i>
                    Semua Transaksi
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentTransaksi ?? [] as $transaksi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaksi->idtransaksi ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $transaksi->idpesanan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaksi->bayar ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaksi->kembali ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $method = $transaksi->metode_pembayaran ?? 'other'; @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($method === 'cash') bg-green-100 text-green-800
                                @elseif($method === 'card') bg-blue-100 text-blue-800
                                @elseif($method === 'qris') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($method) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($transaksi->created_at)->format('H:i') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
