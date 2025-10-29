@extends('layouts.app')

@section('title', 'Edit Pesanan')
@section('page-title', 'Edit Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Pesanan</h2>

        <form action="{{ route('waiter.pesanan.update', $pesanan->idpesanan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="pending" {{ $pesanan->status==='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ $pesanan->status==='proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ $pesanan->status==='selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Pesanan
                </button>
                <a href="{{ route('waiter.pesanan.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


