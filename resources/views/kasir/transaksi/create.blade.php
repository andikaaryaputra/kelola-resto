@extends('layouts.app')

@section('title', 'Buat Transaksi')
@section('page-title', 'Buat Transaksi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Buat Transaksi Pembayaran</h2>

        <form action="{{ route('kasir.transaksi.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="idpesanan" class="block text-sm font-medium text-gray-700 mb-2">Pesanan</label>
                <select id="idpesanan" name="idpesanan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Pesanan</option>
                    @foreach($pesanans as $p)
                        <option value="{{ $p->idpesanan }}">#{{ $p->idpesanan }} - {{ $p->meja->nomormeja ?? '-' }} - Rp {{ number_format($p->total, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @error('idpesanan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select id="metode_pembayaran" name="metode_pembayaran" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="cash">Cash</option>
                    <option value="card">Kartu</option>
                    <option value="transfer">Transfer</option>
                </select>
                @error('metode_pembayaran') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="bayar" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Bayar</label>
                <input type="number" id="bayar" name="bayar" min="0" step="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('bayar') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-credit-card mr-2"></i>Proses Pembayaran
                </button>
                <a href="{{ route('kasir.transaksi.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


