@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="alert alert-success">
        <h5>Selamat Datang, {{ $user->nama_lengkap }}! 👋</h5>
        <p class="mb-0">Berikut adalah hasil analisis profil risiko dan rekomendasi investasi Anda.</p>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Rapor Investasi Anda</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Total Poin Kuesioner:</strong> 
                    <span class="badge bg-secondary">{{ $profile->total_poin }} Poin</span>
                </div>
                <div class="col-md-6">
                    <strong>Profil Risiko Anda:</strong> 
                    <span class="badge bg-warning text-dark">{{ $profile->profil_risiko }}</span>
                </div>
            </div>

            <hr>
            
            <h6>Rekomendasi Alokasi Aset:</h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Saham (Risiko Tinggi)
                    <span class="badge bg-danger rounded-pill">{{ $profile->persen_saham }}%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pasar Uang (Risiko Rendah)
                    <span class="badge bg-success rounded-pill">{{ $profile->persen_pasar_uang }}%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Obligasi / SBN (Risiko Sedang)
                    <span class="badge bg-info text-dark rounded-pill">{{ $profile->persen_obligasi }}%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Campuran / Emas
                    <span class="badge bg-secondary rounded-pill">{{ $profile->persen_campuran }}%</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@stop