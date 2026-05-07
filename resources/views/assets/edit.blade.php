@extends('layout')

@section('content')
<h4>Edit Aset</h4>

{{-- Fitur untuk menampilkan pesan error validasi (jika ada) --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/web/assets/'.$asset->id_aset) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label>Nama Aset</label>
        <input type="text" name="nama_aset" value="{{ $asset->nama_aset }}" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>Kategori</label>
        <input type="text" name="kategori_aset" value="{{ $asset->kategori_aset }}" class="form-control" required>
    </div>

    {{-- INI DIA KOLOM YANG HILANG SEBELUMNYA --}}
    <div class="mb-3">
        <label>Tingkat Risiko</label>
        <select name="tingkat_risiko" class="form-control" required>
            <option value="Rendah" {{ strtolower($asset->tingkat_risiko) == 'rendah' ? 'selected' : '' }}>Rendah</option>
            <option value="Sedang" {{ strtolower($asset->tingkat_risiko) == 'sedang' ? 'selected' : '' }}>Sedang</option>
            <option value="Tinggi" {{ strtolower($asset->tingkat_risiko) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-warning">Update Data</button>
    <a href="{{ url('/web/assets') }}" class="btn btn-secondary">Batal</a>
</form>
@stop