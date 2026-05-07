@extends('layout')

@section('content')
<h4>Tambah User Baru (Registrasi)</h4>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ url('/web/users') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email Terdaftar</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
        <small class="text-muted">Minimal 6 karakter</small>
    </div>
    
    <button type="submit" class="btn btn-success">Daftar User</button>
    <a href="{{ url('/web/users') }}" class="btn btn-secondary">Batal</a>
</form>
@stop