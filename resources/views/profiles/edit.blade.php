@extends('layout')

@section('content')
<h4>Edit Profil Finansial (Kuesioner)</h4>
<form action="{{ url('/web/profiles/'.$profile->id_profil) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label>Sumber Pendapatan</label>
        <input type="text" name="sumber_pendapatan" value="{{ $profile->sumber_pendapatan }}" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>Nominal Pendapatan (Rp)</label>
        <input type="number" name="nominal_pendapatan" value="{{ $profile->nominal_pendapatan }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Persentase Tabungan (%)</label>
        <input type="number" name="persentase_tabungan" value="{{ $profile->persentase_tabungan }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Perilaku Belanja</label>
        <input type="text" name="perilaku_belanja" value="{{ $profile->perilaku_belanja }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tipe Investor</label>
        {{-- Logika untuk otomatis menandai opsi yang tersimpan di database --}}
        <select name="tipe_investor" class="form-select" required>
            <option value="Konservatif" {{ $profile->tipe_investor == 'Konservatif' ? 'selected' : '' }}>Konservatif (Risiko Rendah)</option>
            <option value="Moderat" {{ $profile->tipe_investor == 'Moderat' ? 'selected' : '' }}>Moderat (Risiko Menengah)</option>
            <option value="Agresif" {{ $profile->tipe_investor == 'Agresif' ? 'selected' : '' }}>Agresif (Risiko Tinggi)</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning">Update Profil</button>
    <a href="{{ url('/web/profiles') }}" class="btn btn-secondary">Batal</a>
</form>
@stop