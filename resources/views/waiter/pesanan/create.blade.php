@extends('layouts.app')

@section('title', 'Buat Pesanan')
@section('page-title', 'Buat Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Buat Pesanan Baru</h2>

        <form action="{{ route('waiter.pesanan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="idmeja" class="block text-sm font-medium text-gray-700 mb-2">Meja</label>
                    <select id="idmeja" name="idmeja" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Meja</option>
                        @foreach($mejas as $meja)
                            <option value="{{ $meja->idmeja }}">{{ $meja->nomormeja }} ({{ $meja->kapasitas }} org)</option>
                        @endforeach
                    </select>
                    @error('idmeja') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="namapelanggan" class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan</label>
                    <input type="text" id="namapelanggan" name="namapelanggan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama pelanggan" required>
                    @error('namapelanggan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Pilih Menu</h3>

                <div id="menu-list" class="space-y-3">
                  <div class="space-y-4">
    <h3 class="text-lg font-semibold text-gray-900">Pilih Menu</h3>

    <!-- Scrollable container -->
    <div id="menu-list" class="space-y-4 max-h-96 overflow-y-auto pr-2">
        @foreach($menus as $menu)
        <div class="bg-white border border-gray-200 rounded-xl shadow-md p-5 transition hover:shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                
                <!-- Nama Menu -->
                <div>
                    <div class="text-base font-bold text-gray-900">{{ $menu->namamenu }}</div>
                    <div class="text-sm text-gray-500 mt-1">ID: {{ $menu->idmenu }}</div>
                </div>

                <!-- Harga -->
                <div>
                    <div class="text-sm text-gray-500">Harga</div>
                    <div class="text-lg font-semibold text-green-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                </div>

                <!-- Status -->
                <div>
                    <div class="text-sm text-gray-500">Status</div>
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                        {{ $menu->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $menu->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <!-- Input Jumlah -->
                <div class="flex items-center space-x-2">
                    <input type="number" name="menus[{{ $loop->index }}][jumlah]" value="0" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                    <input type="hidden" name="menus[{{ $loop->index }}][idmenu]" value="{{ $menu->idmenu }}" />
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Pesanan
                </button>
                <a href="{{ route('waiter.pesanan.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


