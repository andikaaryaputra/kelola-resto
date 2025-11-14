@extends('layouts.app')

@section('title', 'Tambah Meja')
@section('page-title', 'Tambah Meja')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4">Tambah Meja Baru</h2>

    <form action="{{ route('admin.meja.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nomormeja" class="block mb-1 text-sm font-medium">Nomor Meja</label>
            <input type="text" 
                   id="nomormeja" 
                   name="nomormeja" 
                   value="{{ old('nomormeja') }}"
                   class="w-full border px-3 py-2"
                   required>
        </div>

        <div>
            <label for="kapasitas" class="block mb-1 text-sm font-medium">Kapasitas</label>
            <input type="number" 
                   id="kapasitas" 
                   name="kapasitas" 
                   value="{{ old('kapasitas') }}"
                   min="1" max="20"
                   class="w-full border px-3 py-2"
                   required>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2">
                Simpan
            </button>

            <a href="{{ route('admin.meja.index') }}" class="bg-gray-200 px-4 py-2">
                Kembali
            </a>
        </div>

    </form>
</div>
@endsection
