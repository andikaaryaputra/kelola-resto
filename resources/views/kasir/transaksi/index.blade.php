@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Daftar Transaksi</h2>
        <a href="{{ route('kasir.transaksi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Buat Transaksi
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $t->idtransaksi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $t->pesanan->meja->nomormeja ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $t->pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($t->metode_pembayaran==='cash') bg-green-100 text-green-800
                                @elseif($t->metode_pembayaran==='card') bg-blue-100 text-blue-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ strtoupper($t->metode_pembayaran) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('kasir.transaksi.show', $t->idtransaksi) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                            <form action="{{ route('kasir.transaksi.destroy', $t->idtransaksi) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-500 mb-2">Belum ada transaksi</h3>
                            <p class="text-gray-400">Transaksi akan tampil di sini setelah pembayaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


