@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Daftar Aset Investasi</h4>
    <a href="{{ url('/web/assets/create') }}" class="btn btn-primary">+ Tambah Aset</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama Aset</th>
            <th>Kategori</th>
            <th>Tingkat Risiko</th>     
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assets as $asset)
        <tr>
            <td>{{ $asset->nama_aset }}</td>
            <td>{{ $asset->kategori_aset }}</td>
            <td>
                {{-- Logika warna untuk memanjakan mata dosen --}}
                @if(strtolower($asset->tingkat_risiko) == 'tinggi')
                    <span class="badge bg-danger">{{ $asset->tingkat_risiko }}</span>
                @elseif(strtolower($asset->tingkat_risiko) == 'sedang')
                    <span class="badge bg-warning text-dark">{{ $asset->tingkat_risiko }}</span>
                @else
                    <span class="badge bg-success">{{ $asset->tingkat_risiko }}</span>
                @endif
            </td>
            <td>
                <a href="{{ url('/web/assets/'.$asset->id_aset.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                
                <form action="{{ url('/web/assets/'.$asset->id_aset) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus aset ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop