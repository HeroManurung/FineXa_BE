<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $a1 = new Asset;
        $a1->nama_aset = 'Pasar Uang';
        $a1->kategori_aset = 'Reksadana';
        $a1->tingkat_risiko = 'Rendah';
        $a1->save();

        $a2 = new Asset;
        $a2->nama_aset = 'Obligasi';
        $a2->kategori_aset = 'SBN';
        $a2->tingkat_risiko = 'Sedang';
        $a2->save();

        $a3 = new Asset;
        $a3->nama_aset = 'Saham';
        $a3->kategori_aset = 'Ekuitas';
        $a3->tingkat_risiko = 'Tinggi';
        $a3->save();

        $a4 = new Asset;
        $a4->nama_aset = 'Emas';
        $a4->kategori_aset = 'Logam Mulia';
        $a4->tingkat_risiko = 'Rendah';
        $a4->save();
    }
}