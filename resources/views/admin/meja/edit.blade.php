@extends('layouts.app')

@section('title', 'Edit Meja')
@section('page-title', 'Edit Meja')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Meja {{ $meja->nomormeja }}</h2>
        
        <form action="{{ route('admin.meja.update', $meja->idmeja) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="nomormeja" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Meja
                </label>
                <input type="text" 
                       id="nomormeja" 
                       name="nomormeja" 
                       value="{{ old('nomormeja', $meja->nomormeja) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Contoh: A1, B2, C3"
                       required>
                @error('nomormeja')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas
                </label>
                <input type="number" 
                       id="kapasitas" 
                       name="kapasitas" 
                       value="{{ old('kapasitas', $meja->kapasitas) }}"
                       min="1" 
                       max="20"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Jumlah maksimal orang"
                       required>
                @error('kapasitas')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="kosong" {{ old('status', $meja->status) === 'kosong' ? 'selected' : '' }}>Kosong</option>
                    <option value="terisi" {{ old('status', $meja->status) === 'terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="maintenance" {{ old('status', $meja->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Meja
                </button>
                <a href="{{ route('admin.meja.index') }}" 
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
