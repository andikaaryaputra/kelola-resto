@extends('layouts.app')

@section('title', 'Buat Pesanan')
@section('page-title', 'Buat Pesanan')

@section('content')

<h2>Buat Pesanan Baru</h2>

<form action="{{ route('waiter.pesanan.store') }}" method="POST">
    @csrf

    <div>
        <label>Meja</label><br>
        <select name="idmeja" required style="border:1px solid #ccc; padding:5px;">
            <option value="">Pilih Meja</option>
            @foreach($mejas as $meja)
                <option value="{{ $meja->idmeja }}">{{ $meja->nomormeja }} ({{ $meja->kapasitas }} org)</option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Nama Pelanggan</label><br>
        <input type="text" name="namapelanggan" required style="border:1px solid #ccc; padding:5px; width:250px;">
    </div>

    <br>

    <h3>Pilih Menu</h3>

    @foreach($menus as $menu)
    <div style="border:1px solid #ddd; padding:8px; margin-bottom:5px;">
        <b>{{ $menu->namamenu }}</b><br>
        Harga: Rp {{ number_format($menu->harga, 0, ',', '.') }} <br>
        Status: {{ $menu->aktif ? 'Aktif' : 'Nonaktif' }} <br>

        <input type="hidden" name="menus[{{ $loop->index }}][idmenu]" value="{{ $menu->idmenu }}">
        Jumlah:
        <input type="number" name="menus[{{ $loop->index }}][jumlah]" value="0" min="0" style="width:60px; border:1px solid #ccc; padding:3px;">
    </div>
    @endforeach

    <br>

    <button type="submit" style="padding:6px 12px; background:#007bff; color:white; border:none;">
        Simpan
    </button>

    <a href="{{ route('waiter.pesanan.index') }}" style="padding:6px 12px; background:#ddd; color:black; text-decoration:none;">
        Kembali
    </a>

</form>

@endsection
