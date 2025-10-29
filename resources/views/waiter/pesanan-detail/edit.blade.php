@extends('layouts.app')

@section('title', 'Edit Detail Pesanan')
@section('page-title', 'Edit Detail Pesanan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Detail</h2>

        <form action="{{ route('waiter.pesanan-detail.update', $detail->iddetail) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pesanan</label>
                <div class="px-4 py-3 border border-gray-200 rounded-lg bg-gray-50">#{{ $detail->idpesanan }}</div>
            </div>

            <div>
                <label for="idmenu" class="block text-sm font-medium text-gray-700 mb-2">Menu</label>
                <select id="idmenu" name="idmenu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    @foreach($menus as $m)
                        <option value="{{ $m->id }}" {{ $detail->idmenu===$m->id ? 'selected' : '' }}>{{ $m->namamenu }} - Rp {{ number_format($m->harga, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @error('idmenu') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', $detail->jumlah) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('jumlah') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Detail
                </button>
                <a href="{{ route('waiter.pesanan-detail.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


