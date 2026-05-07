<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (Dijalankan saat php artisan migrate)
     */
    public function up(): void
    {
        Schema::table('financial_profiles', function (Blueprint $table) {
            // 1. BUANG KOLOM LAMA YANG SUDAH TIDAK RELEVAN
            // Catatan: Pastikan nama-nama ini sesuai dengan yang ada di HeidiSQL kamu sebelumnya ya!
            $table->dropColumn([
                'sumber_pendapatan',
                'nominal_pendapatan',
                'persentase_tabungan',
                'perilaku_belanja',
                'tipe_investor'
            ]);

            // 2. TAMBAH KOLOM BARU (INPUT JAWABAN)
            // Semuanya diberi ->nullable() karena saat daftar akun, nilainya kosong dulu
            $table->integer('skor_waktu')->nullable();
            $table->integer('skor_risiko')->nullable();
            $table->integer('skor_kapasitas')->nullable();
            $table->integer('skor_hutang')->nullable();
            $table->integer('skor_pengetahuan')->nullable();
            $table->integer('total_poin')->nullable();

            // 3. TAMBAH KOLOM BARU (OUTPUT ANALISIS)
            $table->string('profil_risiko')->nullable();
            
            // Menggunakan decimal(5, 2) untuk menampung angka koma seperti 45.50%
            $table->decimal('persen_saham', 5, 2)->nullable();
            $table->decimal('persen_pasar_uang', 5, 2)->nullable();
            $table->decimal('persen_obligasi', 5, 2)->nullable();
            $table->decimal('persen_campuran', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations. (Dijalankan saat php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::table('financial_profiles', function (Blueprint $table) {
            // KEBALIKAN DARI UP(): Hapus kolom baru
            $table->dropColumn([
                'skor_waktu', 'skor_risiko', 'skor_kapasitas', 'skor_hutang', 'skor_pengetahuan', 'total_poin',
                'profil_risiko', 'persen_saham', 'persen_pasar_uang', 'persen_obligasi', 'persen_campuran'
            ]);

            // Kembalikan kolom lama (Beri nullable agar aman)
            $table->string('sumber_pendapatan')->nullable();
            $table->string('nominal_pendapatan')->nullable();
            $table->string('persentase_tabungan')->nullable();
            $table->string('perilaku_belanja')->nullable();
            $table->string('tipe_investor')->nullable();
        });
    }
};