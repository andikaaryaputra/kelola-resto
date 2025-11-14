@extends('layouts.app')

@section('title', 'Edit Meja')
@section('page-title', 'Edit Meja')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4">Edit Meja {{ $meja->nomormeja }}</h2>

    <form action="{{ route('admin.meja.update', $meja->idmeja) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="nomormeja" class="block mb-1 text-sm font-medium">Nomor Meja</label>
            <input type="text" 
                   id="nomormeja" 
                   name="nomormeja" 
                   value="{{ old('nomormeja', $meja->nomormeja) }}"
                   class="w-full border px-3 py-2"
                   required>
        </div>

        <div>
            <label for="kapasitas" class="block mb-1 text-sm font-medium">Kapasitas</label>
            <input type="number" 
                   id="kapasitas" 
                   name="kapasitas" 
                   value="{{ old('kapasitas', $meja->kapasitas) }}"
                   min="1" max="20"
                   class="w-full border px-3 py-2"
                   required>
        </div>

        <div>
            <label for="status" class="block mb-1 text-sm font-medium">Status</label>
            <select id="status" name="status" class="w-full border px-3 py-2">
                <option value="kosong" {{ old('status', $meja->status) == 'kosong' ? 'selected' : '' }}>Kosong</option>
                <option value="terisi" {{ old('status', $meja->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                <option value="maintenance" {{ old('status', $meja->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2">
                Update
            </button>

            <a href="{{ route('admin.meja.index') }}" class="bg-gray-200 px-4 py-2">
                Kembali
            </a>
        </div>

    </form>
</div>
@endsection
