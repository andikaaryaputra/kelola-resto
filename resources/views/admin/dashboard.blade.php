@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100">Kelola meja dan menu restoran dengan mudah</p>
            </div>
            <div class="text-6xl opacity-20">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Meja -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-chair text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Meja</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMeja ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Meja Kosong -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Meja Kosong</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mejaKosong ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Meja Terisi -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Meja Terisi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mejaTerisi ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Menu -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Meja Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Meja</h3>
            <div class="h-64 flex items-center justify-center">
                <div class="relative w-48 h-48">
                    <!-- Pie Chart using CSS -->
                    <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-green-500" 
                         style="clip-path: polygon(50% 50%, 50% 0%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 }}% 0%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 }}% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-yellow-500" 
                         style="clip-path: polygon(50% 50%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 }}% 0%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 }}% 50%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 + (($mejaTerisi ?? 0) / ($totalMeja ?? 1)) * 50 }}% 50%)"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-red-500" 
                         style="clip-path: polygon(50% 50%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 + (($mejaTerisi ?? 0) / ($totalMeja ?? 1)) * 50 }}% 50%, {{ 50 + (($mejaKosong ?? 0) / ($totalMeja ?? 1)) * 50 + (($mejaTerisi ?? 0) / ($totalMeja ?? 1)) * 50 }}% 0%, 50% 0%)"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $totalMeja ?? 0 }}</div>
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
                    <span class="font-semibold text-gray-900">{{ $mejaKosong ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Terisi</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $mejaTerisi ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Menu Status -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Menu Status</h3>
            <div class="h-64 flex items-center justify-center">
                <div class="text-center">
                    <div class="text-6xl text-purple-500 mb-4">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalMenu ?? 0 }}</div>
                    <div class="text-gray-500">Total Menu Aktif</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="bg-gray-200 rounded-full h-4">
                    <div class="bg-purple-500 h-4 rounded-full" style="width: 100%"></div>
                </div>
                <div class="text-sm text-gray-600 mt-2 text-center">100% Menu Aktif</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kelola Meja -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Kelola Meja</h3>
                <i class="fas fa-chair text-2xl text-blue-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Tambah, edit, atau hapus meja restoran</p>
            <div class="space-y-3">
                <a href="{{ route('admin.meja.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Meja Baru
                </a>
                <a href="{{ route('admin.meja.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Meja
                </a>
            </div>
        </div>

        <!-- Kelola Menu -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Kelola Menu</h3>
                <i class="fas fa-utensils text-2xl text-purple-600"></i>
            </div>
            <p class="text-gray-600 mb-4">Tambah, edit, atau hapus menu makanan</p>
            <div class="space-y-3">
                <a href="{{ route('admin.menu.create') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Menu Baru
                </a>
                <a href="{{ route('admin.menu.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Menu
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Meja baru ditambahkan</p>
                    <p class="text-xs text-gray-500">Meja A5 dengan kapasitas 4 orang</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">2 menit lalu</div>
            </div>
            
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-edit text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Menu diperbarui</p>
                    <p class="text-xs text-gray-500">Harga Nasi Goreng diupdate</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">15 menit lalu</div>
            </div>
            
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trash text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Meja dihapus</p>
                    <p class="text-xs text-gray-500">Meja B3 telah dihapus dari sistem</p>
                </div>
                <div class="ml-auto text-xs text-gray-500">1 jam lalu</div>
            </div>
        </div>
    </div>
</div>
@endsection
