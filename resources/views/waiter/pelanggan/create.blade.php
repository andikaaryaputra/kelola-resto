@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Pelanggan Baru</h2>

        <form action="{{ route('waiter.pelanggan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="namapelanggan" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" id="namapelanggan" name="namapelanggan" value="{{ old('namapelanggan') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('namapelanggan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="noip" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                <input type="text" id="noip" name="noip" value="{{ old('noip') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('noip') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('alamat') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="jeniskelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <select id="jeniskelamin" name="jeniskelamin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="1">Laki-laki</option>
                    <option value="0">Perempuan</option>
                </select>
                @error('jeniskelamin') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Pelanggan
                </button>
                <a href="{{ route('waiter.pelanggan.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


