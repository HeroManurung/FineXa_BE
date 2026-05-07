@extends('layout')

@section('content')
<h4>Tambah Aset Baru</h4>
<form action="{{ url('/web/assets') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Aset</label>
        <input type="text" name="nama_aset" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <input type="text" name="kategori_aset" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tingkat Risiko</label>
        <select name="tingkat_risiko" class="form-control">
            <option value="Rendah">Rendah</option>
            <option value="Sedang">Sedang</option>
            <option value="Tinggi">Tinggi</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan Data</button>
    <a href="{{ url('/web/assets') }}" class="btn btn-secondary">Batal</a>
</form>
@stop