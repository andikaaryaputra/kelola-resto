@extends('layouts.app')

@section('title', 'Kelola Meja')
@section('page-title', 'Kelola Meja')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Meja Restaurant</h2>
            <p class="text-gray-600 mt-1">Atur dan kelola meja di restaurant Anda</p>
        </div>
        <a href="{{ route('admin.meja.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            <span class="font-semibold">Tambah Meja</span>
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 rounded-xl p-5 border-2 border-emerald-200 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-700 text-sm font-semibold uppercase tracking-wide">Meja Kosong</p>
                    <p class="text-3xl font-bold text-emerald-900 mt-1">{{ $mejas->where('status', 'kosong')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full p-4 shadow-lg">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 rounded-xl p-5 border-2 border-amber-200 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-700 text-sm font-semibold uppercase tracking-wide">Meja Terisi</p>
                    <p class="text-3xl font-bold text-amber-900 mt-1">{{ $mejas->where('status', 'terisi')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-full p-4 shadow-lg">
                    <i class="fas fa-user-friends text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-rose-50 via-red-50 to-pink-50 rounded-xl p-5 border-2 border-rose-200 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-700 text-sm font-semibold uppercase tracking-wide">Maintenance</p>
                    <p class="text-3xl font-bold text-rose-900 mt-1">{{ $mejas->where('status', 'maintenance')->count() }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-full p-4 shadow-lg">
                    <i class="fas fa-tools text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Meja Grid dengan Visual Meja Lingkaran -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($mejas as $meja)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 relative overflow-hidden group">
            
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 rounded-full opacity-20
                @if($meja->status === 'kosong') bg-gradient-to-br from-emerald-400 to-teal-500
                @elseif($meja->status === 'terisi') bg-gradient-to-br from-amber-400 to-orange-500
                @elseif($meja->status === 'maintenance') bg-gradient-to-br from-rose-400 to-pink-500
                @else bg-gradient-to-br from-gray-400 to-gray-500 @endif">
            </div>
            
            <!-- Visual Meja Lingkaran -->
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <!-- Meja (Lingkaran Besar) -->
                    <div class="w-36 h-36 rounded-full flex items-center justify-center shadow-2xl relative
                        @if($meja->status === 'kosong') bg-gradient-to-br from-emerald-400 via-green-500 to-teal-600
                        @elseif($meja->status === 'terisi') bg-gradient-to-br from-amber-400 via-yellow-500 to-orange-600
                        @elseif($meja->status === 'maintenance') bg-gradient-to-br from-rose-400 via-red-500 to-pink-600
                        @else bg-gradient-to-br from-gray-400 via-gray-500 to-gray-600 @endif">
                        
                        <!-- Inner Circle -->
                        <div class="w-28 h-28 rounded-full bg-white bg-opacity-30 backdrop-blur-sm flex items-center justify-center ring-4 ring-white ring-opacity-20">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white drop-shadow-lg">{{ $meja->nomormeja }}</div>
                            </div>
                        </div>
                        
                        <!-- Kursi (lingkaran kecil di sekitar meja sesuai kapasitas) -->
                        @for($i = 0; $i < $meja->kapasitas; $i++)
                            @php
                                $angle = ($i * (360 / $meja->kapasitas)) - 90;
                                $radian = deg2rad($angle);
                                $radius = 70;
                                $x = cos($radian) * $radius;
                                $y = sin($radian) * $radius;
                            @endphp
                            <div class="absolute w-7 h-7 rounded-full shadow-lg border-3 flex items-center justify-center
                                @if($meja->status === 'kosong') bg-green-50 border-green-700
                                @elseif($meja->status === 'terisi') bg-yellow-50 border-yellow-700
                                @elseif($meja->status === 'maintenance') bg-red-50 border-red-700
                                @else bg-gray-50 border-gray-700 @endif"
                                style="left: 50%; top: 50%; transform: translate(calc(-50% + {{ $x }}px), calc(-50% + {{ $y }}px));">
                                <i class="fas fa-user text-xs
                                    @if($meja->status === 'kosong') text-green-700
                                    @elseif($meja->status === 'terisi') text-yellow-700
                                    @elseif($meja->status === 'maintenance') text-red-700
                                    @else text-gray-700 @endif"></i>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="flex justify-center mb-4">
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide
                    @if($meja->status === 'kosong') bg-green-100 text-green-700 ring-2 ring-green-300
                    @elseif($meja->status === 'terisi') bg-yellow-100 text-yellow-700 ring-2 ring-yellow-300
                    @elseif($meja->status === 'maintenance') bg-red-100 text-red-700 ring-2 ring-red-300
                    @else bg-gray-100 text-gray-700 ring-2 ring-gray-300 @endif">
                    <i class="fas fa-circle text-xs mr-1"></i>
                    {{ ucfirst($meja->status) }}
                </span>
            </div>
            
            <!-- Info Meja -->
            <div class="space-y-3 mb-4">
                <div class="flex items-center justify-center text-gray-700 bg-gray-50 rounded-lg py-2 px-3">
                    <i class="fas fa-users text-blue-600 mr-2"></i>
                    <span class="font-semibold">Kapasitas: {{ $meja->kapasitas }} orang</span>
                </div>
                <div class="flex items-center justify-center text-gray-600 text-sm">
                    <i class="fas fa-clock mr-2"></i>
                    <span>{{ optional($meja->created_at)->format('d M Y') ?? '-' }}</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.meja.edit', $meja->idmeja) }}" 
                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-center py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
                <form action="{{ route('admin.meja.destroy', $meja->idmeja) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg font-medium"
                            onclick="return confirm('Yakin ingin menghapus meja {{ $meja->nomormeja }}?')">
                        <i class="fas fa-trash mr-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl">
            <div class="inline-block p-6 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-chair text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum ada meja tersedia</h3>
            <p class="text-gray-500 mb-6">Mulai kelola restaurant Anda dengan menambahkan meja pertama</p>
            <a href="{{ route('admin.meja.create') }}" 
               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <i class="fas fa-plus mr-2"></i>
                <span class="font-semibold">Tambah Meja Sekarang</span>
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Animasi hover untuk card */
    .group:hover {
        transform: translateY(-5px);
    }
    
    /* Animasi pulse untuk status badge */
    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5);
        }
        100% {
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }
    }
</style>
@endsection     