@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<h2>Edit User: {{ $user->name }}</h2>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <br>

    <label>Nama:</label><br>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" required><br>
    @error('name') <small>{{ $message }}</small> @enderror

    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" required><br>
    @error('email') <small>{{ $message }}</small> @enderror

    <br><br>

    <label>Password Baru (kosongkan jika tidak ingin mengubah):</label><br>
    <input type="password" name="password"><br>
    @error('password') <small>{{ $message }}</small> @enderror

    <br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="administrator" {{ $user->role === 'administrator' ? 'selected' : '' }}>Administrator</option>
        <option value="waiter" {{ $user->role === 'waiter' ? 'selected' : '' }}>Waiter</option>
        <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
        <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
    </select>
    @error('role') <small>{{ $message }}</small> @enderror

    <br><br><br>

    <button type="submit">Update User</button>
    <a href="{{ route('admin.users.index') }}">Kembali</a>

</form>

@endsection
