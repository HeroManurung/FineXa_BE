@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Profil Finansial</h4>
    {{-- Sengaja dikosongkan tanpa tombol tambah profil, karena mengikuti pembuatan User --}}
</div>

{{-- Menampilkan pesan sukses kalau habis diedit --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-hover mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID Profil</th>
            <th>Nama Pemilik</th>
            <th>Sumber Pendapatan</th>
            <th>Nominal</th>
            <th>Tipe Investor</th>
            <th>Aksi</th> {{-- Tambahan Kolom Aksi --}}
        </tr>
    </thead>
    <tbody>
        @foreach($profiles as $profile)
        <tr>
            <td>{{ $profile->id_profil }}</td>
            {{-- Mengambil nama dari tabel users (Relasi Eloquent) --}}
            <td>{{ $profile->user->nama_lengkap ?? 'User Tidak Diketahui' }}</td>
            <td>{{ $profile->sumber_pendapatan }}</td>
            <td>Rp {{ number_format($profile->nominal_pendapatan, 0, ',', '.') }}</td>
            <td>
                {{-- Bikin warna badge makin variatif sesuai profil risikonya --}}
                @if($profile->tipe_investor == 'Agresif')
                    <span class="badge bg-danger">{{ $profile->tipe_investor }}</span>
                @elseif($profile->tipe_investor == 'Moderat')
                    <span class="badge bg-warning text-dark">{{ $profile->tipe_investor }}</span>
                @elseif($profile->tipe_investor == 'Konservatif')
                    <span class="badge bg-success">{{ $profile->tipe_investor }}</span>
                @else
                    <span class="badge bg-secondary">{{ $profile->tipe_investor }}</span>
                @endif
            </td>
            <td>
                {{-- Tombol Edit Saja --}}
                <a href="{{ url('/web/profiles/'.$profile->id_profil.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop