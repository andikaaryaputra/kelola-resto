@extends('layouts.app')

@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Menu Baru</h2>
        
        <form action="{{ route('admin.menu.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="namamenu" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Menu
                </label>
                <input type="text" 
                       id="namamenu" 
                       name="namamenu" 
                       value="{{ old('namamenu') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Contoh: Nasi Goreng Spesial"
                       required>
                @error('namamenu')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <input type="number" 
                           id="harga" 
                           name="harga" 
                           value="{{ old('harga') }}"
                           min="0"
                           step="100"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="25000"
                           required>
                </div>
                @error('harga')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Menu
                </button>
                <a href="{{ route('admin.menu.index') }}" 
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
