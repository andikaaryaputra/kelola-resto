@extends('layouts.app')

@section('title', 'Waiter Dashboard')
@section('page-title', 'Waiter Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-green-100">Kelola pesanan dan pelanggan dengan efisien</p>
            </div>
            <div class="text-6xl opacity-20">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pesanan -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPesanan ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pesanan Pending -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pesananPending ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pesanan Proses -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-spinner text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Proses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pesananProses ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPelanggan ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

     <!-- Charts Section -->
     <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
         <!-- Status Pesanan Chart -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan</h3>
             <div class="h-64 flex items-center justify-center">
                 @php
                     $totalPesanan = $totalPesanan ?? 0;
                     $pesananPending = $pesananPending ?? 0;
                     $pesananProses = $pesananProses ?? 0;
                     $pesananSelesai = $totalPesanan - $pesananPending - $pesananProses;
                     
                     if ($totalPesanan > 0) {
                         $pendingPercent = ($pesananPending / $totalPesanan) * 100;
                         $prosesPercent = ($pesananProses / $totalPesanan) * 100;
                         $selesaiPercent = ($pesananSelesai / $totalPesanan) * 100;
                     } else {
                         $pendingPercent = 0;
                         $prosesPercent = 0;
                         $selesaiPercent = 0;
                     }
                 @endphp
                 
                 <div class="relative w-48 h-48">
                     <!-- Pie Chart using CSS -->
                     <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                     
                     @if($totalPesanan > 0)
                         <!-- Pending slice -->
                         <div class="absolute inset-0 rounded-full border-8 border-yellow-500" 
                              style="clip-path: polygon(50% 50%, 50% 0%, {{ 50 + sin(deg2rad($pendingPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($pendingPercent * 3.6)) * 50 }}%, 50% 50%)"></div>
                         
                         <!-- Proses slice -->
                         <div class="absolute inset-0 rounded-full border-8 border-blue-500" 
                              style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad($pendingPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($pendingPercent * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($pendingPercent + $prosesPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($pendingPercent + $prosesPercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                         
                         <!-- Selesai slice -->
                         <div class="absolute inset-0 rounded-full border-8 border-green-500" 
                              style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad(($pendingPercent + $prosesPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($pendingPercent + $prosesPercent) * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($pendingPercent + $prosesPercent + $selesaiPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($pendingPercent + $prosesPercent + $selesaiPercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                     @endif
                     
                     <div class="absolute inset-0 flex items-center justify-center">
                         <div class="text-center">
                             <div class="text-2xl font-bold text-gray-900">{{ $totalPesanan }}</div>
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
                     <span class="font-semibold text-gray-900">{{ $pesananPending }}</span>
                 </div>
                 <div class="flex items-center justify-between">
                     <div class="flex items-center">
                         <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                         <span class="text-gray-700">Proses</span>
                     </div>
                     <span class="font-semibold text-gray-900">{{ $pesananProses }}</span>
                 </div>
                 <div class="flex items-center justify-between">
                     <div class="flex items-center">
                         <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                         <span class="text-gray-700">Selesai</span>
                     </div>
                     <span class="font-semibold text-gray-900">{{ $pesananSelesai }}</span>
                 </div>
             </div>
         </div>

         <!-- Pelanggan Chart -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <h3 class="text-xl font-semibold text-gray-900 mb-4">Data Pelanggan</h3>
             <div class="h-64 flex items-center justify-center">
                 <div class="text-center">
                     <div class="text-6xl text-purple-500 mb-4">
                         <i class="fas fa-users"></i>
                     </div>
                     <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalPelanggan ?? 0 }}</div>
                     <div class="text-gray-500">Total Pelanggan</div>
                 </div>
             </div>
             <div class="mt-4">
                 <div class="bg-gray-200 rounded-full h-4">
                     <div class="bg-purple-500 h-4 rounded-full" style="width: {{ min(100, ($totalPelanggan ?? 0) * 10) }}%"></div>
                 </div>
                 <div class="text-sm text-gray-600 mt-2 text-center">{{ $totalPelanggan ?? 0 }} Pelanggan Terdaftar</div>
             </div>
         </div>
     </div>

     <!-- Additional Charts Section -->
     <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
         <!-- Pesanan per Hari Chart -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <h3 class="text-xl font-semibold text-gray-900 mb-4">Pesanan 7 Hari Terakhir</h3>
             <div class="h-64 flex items-end justify-between space-x-2">
                 @php
                     $chartData = [];
                     for ($i = 6; $i >= 0; $i--) {
                         $date = now()->subDays($i)->format('Y-m-d');
                         $count = \App\Models\Pesanan::whereDate('created_at', $date)->count();
                         $chartData[] = [
                             'date' => now()->subDays($i)->format('d/m'),
                             'count' => $count
                         ];
                     }
                     $maxCount = max(array_column($chartData, 'count'));
                 @endphp
                 
                 @foreach($chartData as $data)
                     @php
                         $height = $maxCount > 0 ? ($data['count'] / $maxCount) * 100 : 5;
                     @endphp
                     <div class="flex flex-col items-center flex-1">
                         <div class="w-full bg-gradient-to-t from-green-500 to-green-300 rounded-t transition-all duration-500 hover:from-green-600 hover:to-green-400" 
                              style="height: {{ $height }}%; min-height: 20px;" 
                              title="{{ $data['count'] }} pesanan">
                         </div>
                         <div class="text-xs text-gray-500 mt-2">{{ $data['date'] }}</div>
                         <div class="text-xs text-gray-700 font-medium">{{ $data['count'] }}</div>
                     </div>
                 @endforeach
             </div>
         </div>

         <!-- Status Meja Chart -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Meja</h3>
             <div class="h-64 flex items-center justify-center">
                 @php
                     $totalMeja = \App\Models\Meja::count();
                     $mejaKosong = \App\Models\Meja::where('status', 'kosong')->count();
                     $mejaTerisi = \App\Models\Meja::where('status', 'terisi')->count();
                     $mejaMaintenance = \App\Models\Meja::where('status', 'maintenance')->count();
                 @endphp
                 
                 <div class="relative w-48 h-48">
                     <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                     
                     @if($totalMeja > 0)
                         @php
                             $kosongPercent = ($mejaKosong / $totalMeja) * 100;
                             $terisiPercent = ($mejaTerisi / $totalMeja) * 100;
                             $maintenancePercent = ($mejaMaintenance / $totalMeja) * 100;
                         @endphp
                         
                         <div class="absolute inset-0 rounded-full border-8 border-green-500" 
                              style="clip-path: polygon(50% 50%, 50% 0%, {{ 50 + sin(deg2rad($kosongPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($kosongPercent * 3.6)) * 50 }}%, 50% 50%)"></div>
                         
                         <div class="absolute inset-0 rounded-full border-8 border-yellow-500" 
                              style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad($kosongPercent * 3.6)) * 50 }}% {{ 50 - cos(deg2rad($kosongPercent * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($kosongPercent + $terisiPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($kosongPercent + $terisiPercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                         
                         <div class="absolute inset-0 rounded-full border-8 border-red-500" 
                              style="clip-path: polygon(50% 50%, {{ 50 + sin(deg2rad(($kosongPercent + $terisiPercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($kosongPercent + $terisiPercent) * 3.6)) * 50 }}%, {{ 50 + sin(deg2rad(($kosongPercent + $terisiPercent + $maintenancePercent) * 3.6)) * 50 }}% {{ 50 - cos(deg2rad(($kosongPercent + $terisiPercent + $maintenancePercent) * 3.6)) * 50 }}%, 50% 50%)"></div>
                     @endif
                     
                     <div class="absolute inset-0 flex items-center justify-center">
                         <div class="text-center">
                             <div class="text-2xl font-bold text-gray-900">{{ $totalMeja }}</div>
                             <div class="text-sm text-gray-500">Total Meja</div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="mt-4 space-y-2">
                 <div class="flex items-center justify-between">
                     <div class="flex items-center">
                         <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                         <span class="text-gray-700">Kosong</span>
                     </div>
                     <span class="font-semibold text-gray-900">{{ $mejaKosong }}</span>
                 </div>
                 <div class="flex items-center justify-between">
                     <div class="flex items-center">
                         <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                         <span class="text-gray-700">Terisi</span>
                     </div>
                     <span class="font-semibold text-gray-900">{{ $mejaTerisi }}</span>
                 </div>
                 <div class="flex items-center justify-between">
                     <div class="flex items-center">
                         <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                         <span class="text-gray-700">Maintenance</span>
                     </div>
                     <span class="font-semibold text-gray-900">{{ $mejaMaintenance }}</span>
                 </div>
             </div>
         </div>
     </div>

     <!-- Quick Actions -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
         <!-- Kelola Pesanan -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-xl font-semibold text-gray-900">Kelola Pesanan</h3>
                 <i class="fas fa-clipboard-list text-2xl text-blue-600"></i>
             </div>
             <p class="text-gray-600 mb-4">Buat dan kelola pesanan pelanggan</p>
             <div class="space-y-3">
                 <a href="{{ route('waiter.pesanan.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-plus mr-2"></i>
                     Buat Pesanan Baru
                 </a>
                 <a href="{{ route('waiter.pesanan.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-list mr-2"></i>
                     Lihat Semua Pesanan
                 </a>
             </div>
         </div>

         <!-- Kelola Pelanggan -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-xl font-semibold text-gray-900">Kelola Pelanggan</h3>
                 <i class="fas fa-users text-2xl text-purple-600"></i>
             </div>
             <p class="text-gray-600 mb-4">Tambah dan kelola data pelanggan</p>
             <div class="space-y-3">
                 <a href="{{ route('waiter.pelanggan.create') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-plus mr-2"></i>
                     Tambah Pelanggan
                 </a>
                 <a href="{{ route('waiter.pelanggan.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-list mr-2"></i>
                     Lihat Semua Pelanggan
                 </a>
             </div>
         </div>

         <!-- Laporan -->
         <div class="bg-white rounded-xl shadow-lg p-6">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-xl font-semibold text-gray-900">Laporan</h3>
                 <i class="fas fa-chart-bar text-2xl text-green-600"></i>
             </div>
             <p class="text-gray-600 mb-4">Lihat laporan pesanan dan statistik</p>
             <div class="space-y-3">
                 <a href="{{ route('waiter.laporan') }}" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-file-alt mr-2"></i>
                     Lihat Laporan
                 </a>
                 <a href="{{ route('waiter.laporan.print') }}" target="_blank" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                     <i class="fas fa-print mr-2"></i>
                     Cetak Laporan
                 </a>
             </div>
         </div>
     </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                 <tbody class="bg-white divide-y divide-gray-200">
                     @forelse($recentPesanan ?? [] as $pesanan)
                     <tr>
                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $pesanan->idpesanan ?? '-' }}</td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->meja->nomormeja ?? '-' }}</td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($pesanan->total ?? 0, 0, ',', '.') }}</td>
                         <td class="px-6 py-4 whitespace-nowrap">
                             @php
                                 $status = $pesanan->status ?? 'unknown';
                             @endphp
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                 @if($status === 'pending') bg-yellow-100 text-yellow-800
                                 @elseif($status === 'proses') bg-orange-100 text-orange-800
                                 @elseif($status === 'selesai') bg-green-100 text-green-800
                                 @else bg-gray-100 text-gray-800 @endif">
                                 {{ ucfirst($status) }}
                             </span>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                             <a href="{{ route('waiter.pesanan.edit', $pesanan->idpesanan ?? 0) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                         </td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada pesanan</td>
                     </tr>
                     @endforelse
                 </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
