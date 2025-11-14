@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white p-6 shadow rounded-lg">

        <h2 class="text-xl font-semibold mb-4">Tambah User Baru</h2>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role" class="w-full border p-2 rounded">
                    <option value="administrator">Administrator</option>
                    <option value="waiter">Waiter</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
