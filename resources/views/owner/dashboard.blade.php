@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('page-title', 'Owner Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-purple-100">Pantau performa restoran dan kelola bisnis</p>
            </div>
            <div class="text-6xl opacity-20">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pendapatan Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Transaksi Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $transaksiHariIni ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Meja -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-chair text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Meja</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMeja ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Menu -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-utensils text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Menu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMenu ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pendapatan Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Pendapatan 7 Hari Terakhir</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @foreach($chartData as $data)
                    @php
                        $maxRevenue = max(array_column($chartData, 'revenue'));
                        $height = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 100 : 5;
                    @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-blue-500 to-blue-300 rounded-t transition-all duration-500 hover:from-blue-600 hover:to-blue-400" 
                             style="height: {{ $height }}%; min-height: 20px;" 
                             title="Rp {{ number_format($data['revenue'], 0, ',', '.') }}">
                        </div>
                        <div class="text-xs text-gray-500 mt-2">{{ $data['date'] }}</div>
                        <div class="text-xs text-gray-700 font-medium">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status Meja -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Meja</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Meja Kosong</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $mejaKosong ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Meja Terisi</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $mejaTerisi ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Maintenance</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $mejaMaintenance ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Status Pesanan Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan Hari Ini</h3>
            <div class="h-64 flex items-center justify-center">
                @php
                    $st = $statusToday ?? ['pending'=>0,'proses'=>0,'selesai'=>0,'lunas'=>0];
                    $totalSt = max(1, array_sum($st));
                    $p = ($st['pending'] / $totalSt) * 100;
                    $r = ($st['proses'] / $totalSt) * 100;
                    $s = ($st['selesai'] / $totalSt) * 100;
                    $l = 100 - $p - $r - $s;
                @endphp
                <div class="relative w-48 h-48">
                    <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-yellow-500" 
                         style="clip-path: polygon(50% 50%, 50% 0%, {{ 50 + sin(deg2rad($p * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($p * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-blue-500" 
                         style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad($p * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($p * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($p + $r) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($p + $r) * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-green-500" 
                         style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad(($p + $r) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($p + $r) * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($p + $r + $s) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($p + $r + $s) * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-purple-500" 
                         style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad(($p + $r + $s) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($p + $r + $s) * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($p + $r + $s + $l) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($p + $r + $s + $l) * 3.6)) * 50 }}%, 50% 50%)"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $totalSt - 1 + 1 }}</div>
                            <div class="text-sm text-gray-500">Total Pesanan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Pending</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $st['pending'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Proses</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $st['proses'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Selesai</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $st['selesai'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Lunas</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $st['lunas'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Laporan -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Laporan</h3>
                <i class="fas fa-chart-bar text-2xl text-blue-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Lihat laporan lengkap restoran</p>
            <a href="{{ route('owner.laporan') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-file-alt mr-2"></i>
                Lihat Laporan
            </a>
        </div>

        <!-- Kelola Staff -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Kelola Staff</h3>
                <i class="fas fa-users text-2xl text-purple-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Kelola data staff dan user</p>
            <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-cog mr-2"></i>
                Kelola Staff
            </button>
        </div>

        <!-- Pengaturan -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Pengaturan</h3>
                <i class="fas fa-cog text-2xl text-gray-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Pengaturan sistem dan restoran</p>
            <button class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-wrench mr-2"></i>
                Pengaturan
            </button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Transaksi baru</p>
                    <p class="text-xs text-gray-500">Pembayaran Rp 150.000 untuk pesanan #123</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">5 menit lalu</div>
            </div>
            
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Pesanan baru</p>
                    <p class="text-xs text-gray-500">Pesanan #124 untuk meja A3</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">15 menit lalu</div>
            </div>
            
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Pelanggan baru</p>
                    <p class="text-xs text-gray-500">John Doe terdaftar sebagai pelanggan</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">1 jam lalu</div>
            </div>
        </div>
    </div>
</div>
@endsection
