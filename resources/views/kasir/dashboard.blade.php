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
            <p class="text-2xl font-bold">
                Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
            </p>
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

</div>
@endsection
