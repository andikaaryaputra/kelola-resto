@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('page-title', 'Dashboard Owner')

@section('content')
<div class="space-y-6">

    <!-- Judul -->
    <div class="bg-white p-4 rounded-lg border">
        <h2 class="text-xl font-semibold">Selamat Datang, {{ Auth::user()->name }}</h2>
        <p class="text-gray-600 text-sm">Ringkasan data restoran hari ini</p>
    </div>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Pendapatan Hari Ini</p>
            <p class="text-xl font-bold">Rp {{ number_format($pendapatanHariIni,0,',','.') }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Total Transaksi</p>
            <p class="text-xl font-bold">{{ $transaksiHariIni }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p class="text-gray-600 text-sm">Total Meja</p>
            <p class="text-xl font-bold">{{ $totalMeja }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg border">
            <p="text-gray-600 text-sm">Total Menu</p>
            <p class="text-xl font-bold">{{ $totalMenu }}</p>
        </div>

    </div>

    <!-- Status Meja -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="text-lg font-semibold mb-3">Status Meja</h3>
        <ul class="space-y-1 text-sm">
            <li>Meja Kosong: <strong>{{ $mejaKosong }}</strong></li>
            <li>Meja Terisi: <strong>{{ $mejaTerisi }}</strong></li>
            <li>Meja Maintenance: <strong>{{ $mejaMaintenance }}</strong></li>
        </ul>
    </div>

    <!-- Status Pesanan -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="text-lg font-semibold mb-3">Status Pesanan Hari Ini</h3>
        <ul class="space-y-1 text-sm">
            <li>Pending: <strong>{{ $statusToday['pending'] }}</strong></li>
            <li>Proses: <strong>{{ $statusToday['proses'] }}</strong></li>
            <li>Selesai: <strong>{{ $statusToday['selesai'] }}</strong></li>
            <li>Lunas: <strong>{{ $statusToday['lunas'] }}</strong></li>
        </ul>
    </div>

    <!-- Tombol -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="text-lg font-semibold mb-3">Menu Cepat</h3>
        <a href="{{ route('owner.laporan') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded text-sm">
            Lihat Laporan
        </a>
    </div>

</div>
@endsection
