<?php

namespace Database\Seeders;

use App\Models\FinancialProfile;
use Illuminate\Database\Seeder;

class FinancialProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Profil 1: User yang sudah mengisi kuesioner dan hasilnya Agresif
        $p1 = new FinancialProfile;
        $p1->id_user = 1;
        $p1->skor_waktu = 3;
        $p1->skor_risiko = 3;
        $p1->skor_kapasitas = 3;
        $p1->skor_hutang = 3;
        $p1->skor_pengetahuan = 3;
        $p1->total_poin = 15;
        $p1->profil_risiko = 'Sangat Agresif';
        $p1->persen_saham = 60.00;
        $p1->persen_pasar_uang = 0.00;
        $p1->persen_obligasi = 24.00;
        $p1->persen_campuran = 16.00;
        $p1->save();

        // Profil 2: User yang sudah mengisi kuesioner dan hasilnya Konservatif
        $p2 = new FinancialProfile;
        $p2->id_user = 3;
        $p2->skor_waktu = 1;
        $p2->skor_risiko = 1;
        $p2->skor_kapasitas = 1;
        $p2->skor_hutang = 1;
        $p2->skor_pengetahuan = 1;
        $p2->total_poin = 5;
        $p2->profil_risiko = 'Sangat Konservatif';
        $p2->persen_saham = 0.00;
        $p2->persen_pasar_uang = 70.00;
        $p2->persen_obligasi = 18.00;
        $p2->persen_campuran = 12.00;
        $p2->save();

        // Profil 3: User yang BELUM mengisi kuesioner (Masih Kosong)
        // Sama seperti logika saat registrasi user baru
        $p3 = new FinancialProfile;
        $p3->id_user = 4;
        $p3->save();

        // Profil 4: User Moderat
        $p4 = new FinancialProfile;
        $p4->id_user = 5;
        $p4->skor_waktu = 2;
        $p4->skor_risiko = 2;
        $p4->skor_kapasitas = 2;
        $p4->skor_hutang = 2;
        $p4->skor_pengetahuan = 2;
        $p4->total_poin = 10;
        $p4->profil_risiko = 'Moderat';
        $p4->persen_saham = 30.00;
        $p4->persen_pasar_uang = 35.00;
        $p4->persen_obligasi = 21.00;
        $p4->persen_campuran = 14.00;
        $p4->save();
    }
}