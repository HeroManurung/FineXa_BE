@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Pengguna FineXa</h4>
</div>

<table class="table table-bordered table-hover mt-3">
    <thead class="table-primary">
        <tr>
            <th>ID User</th>
            <th>Nama Lengkap</th>
            <th>Email Terdaftar</th>
            <th>Role / Peran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id_user }}</td>
            <td>{{ $user->nama_lengkap }}</td>
            <td>{{ $user->email }}</td>
            <td>
                {{-- Bikin warna beda kalau rolenya admin atau investor --}}
                @if($user->role == 'admin')
                    <span class="badge bg-danger">Admin</span>
                @else
                    <span class="badge bg-info text-dark">Investor</span>
                @endif
            </td>
            <td>
                <form action="{{ url('/web/users/' . $user->id_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin untuk Menghapus User ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        🗑️ Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop