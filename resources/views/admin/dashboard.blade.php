@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<h2>Selamat Datang, {{ Auth::user()->name }}</h2>
<p>Ini adalah halaman dashboard admin.</p>
<hr><br>

<h3>Statistik Sistem</h3>
<ul>
    <li>Total Meja: <b>{{ $totalMeja ?? 0 }}</b></li>
    <li>Meja Kosong: <b>{{ $mejaKosong ?? 0 }}</b></li>
    <li>Meja Terisi: <b>{{ $mejaTerisi ?? 0 }}</b></li>
    <li>Total Menu Aktif: <b>{{ $totalMenu ?? 0 }}</b></li>
</ul>

<br><hr><br>

<h3>Aktivitas Terbaru</h3>
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <th>Aktivitas</th>
        <th>Keterangan</th>
        <th>Waktu</th>
    </tr>
    <tr>
        <td>Meja baru ditambahkan</td>
        <td>Meja A5 (4 orang)</td>
        <td>2 menit lalu</td>
    </tr>
    <tr>
        <td>Menu diperbarui</td>
        <td>Harga Nasi Goreng diperbarui</td>
        <td>15 menit lalu</td>
    </tr>
    <tr>
        <td>Meja dihapus</td>
        <td>Meja B3 dihapus dari sistem</td>
        <td>1 jam lalu</td>
    </tr>
</table>

@endsection
