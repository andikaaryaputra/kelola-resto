@extends('layouts.app')

@section('title', 'Kasir Dashboard')
@section('page-title', 'Kasir Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome -->
    <div class="bg-white p-4 rounded shadow">
        <h1 class="text-xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 text-sm">{{ now()->format('d M Y, H:i') }}</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-sm text-gray-600">Transaksi Hari Ini</p>
            <p class="text-2xl font-bold">{{ $transaksiHariIni ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-sm text-gray-600">Pendapatan Hari Ini</p>
            <p class="text-2xl font-bold">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-sm text-gray-600">Siap Bayar</p>
            <p class="text-2xl font-bold">{{ $pesananSiapBayar ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center">
            <p class="text-sm text-gray-600">Total Transaksi</p>
            <p class="text-2xl font-bold">{{ $totalTransaksi ?? 0 }}</p>
        </div>

    </div>

    <!-- Quick Menu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold mb-2">Proses Pembayaran</h3>
            <div class="space-y-2">
                <a href="{{ route('kasir.siap-bayar') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded">
                    Pesanan Siap Bayar
                </a>
                <a href="{{ route('kasir.transaksi.create') }}" class="block w-full bg-gray-200 text-gray-800 text-center py-2 rounded">
                    Buat Transaksi Baru
                </a>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold mb-2">Laporan Transaksi</h3>
            <div class="space-y-2">
                <a href="{{ route('kasir.hari-ini') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded">
                    Laporan Hari Ini
                </a>
                <a href="{{ route('kasir.hari-ini.print') }}" target="_blank" class="block w-full bg-gray-200 text-gray-800 text-center py-2 rounded">
                    Cetak Laporan
                </a>
                <a href="{{ route('kasir.transaksi.index') }}" class="block w-full bg-gray-200 text-gray-800 text-center py-2 rounded">
                    Semua Transaksi
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
