@extends('layouts.app')

@section('title', 'Kelola Meja')
@section('page-title', 'Kelola Meja')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Kelola Meja</h2>
        <a href="{{ route('admin.meja.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-md">
            + Tambah Meja
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 border rounded-md bg-white">
            <p class="text-gray-600 text-sm">Meja Kosong</p>
            <p class="text-2xl font-bold">{{ $mejas->where('status', 'kosong')->count() }}</p>
        </div>

        <div class="p-4 border rounded-md bg-white">
            <p class="text-gray-600 text-sm">Meja Terisi</p>
            <p class="text-2xl font-bold">{{ $mejas->where('status', 'terisi')->count() }}</p>
        </div>

        <div class="p-4 border rounded-md bg-white">
            <p class="text-gray-600 text-sm">Maintenance</p>
            <p class="text-2xl font-bold">{{ $mejas->where('status', 'maintenance')->count() }}</p>
        </div>
    </div>

    <!-- List Meja -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($mejas as $meja)
        <div class="border bg-white rounded-md p-4">
            
            <h3 class="text-xl font-bold mb-2">Meja {{ $meja->nomormeja }}</h3>

            <p>Status: 
                <span class="font-semibold">
                    {{ ucfirst($meja->status) }}
                </span>
            </p>

            <p>Kapasitas: {{ $meja->kapasitas }} orang</p>
            <p>Dibuat: {{ optional($meja->created_at)->format('d M Y') }}</p>

            <div class="flex gap-2 mt-4">
                <a href="{{ route('admin.meja.edit', $meja->idmeja) }}" 
                   class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                    Edit
                </a>

                <form action="{{ route('admin.meja.destroy', $meja->idmeja) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md text-sm"
                            onclick="return confirm('Yakin ingin menghapus meja ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        @empty
        <div class="col-span-full bg-white border rounded-md p-10 text-center">
            <p class="text-lg font-semibold mb-3">Belum ada meja</p>
            <a href="{{ route('admin.meja.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md">
                Tambah Meja
            </a>
        </div>
        @endforelse
    </div>

</div>
@endsection
