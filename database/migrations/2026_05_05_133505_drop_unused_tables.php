<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (Proses Penghapusan)
     */
    public function up(): void
    {
        // Hapus tabel anak (pivot) dulu
        Schema::dropIfExists('profile_challenges');
        
        // lalu hapus tabel induknya
        Schema::dropIfExists('master_challenges');
        
        // Terakhir, hapus tabel rekomendasi
        Schema::dropIfExists('recommendations');
    }

    /**
     * Reverse the migrations. (Tombol Undo jika suatu saat butuh tabel ini lagi)
     */
    public function down(): void
    {
        // --- Bikin ulang tabel Master Challenges ---
        Schema::create('master_challenges', function (Blueprint $table) {
            $table->id('id_tantangan');
            $table->string('nama_tantangan');
            $table->timestamps();
        });

        // --- Bikin ulang tabel Profile Challenges ---
        Schema::create('profile_challenges', function (Blueprint $table) {
            $table->string('id_profil'); // Sesuaikan tipe datanya dengan aslimu
            $table->unsignedBigInteger('id_tantangan');
            // Jika sebelumnya ada foreign key, set disini
            $table->timestamps();
        });

        // --- Bikin ulang tabel Recommendations ---
        Schema::create('recommendations', function (Blueprint $table) {
            $table->string('id_user'); // Sesuaikan tipe datanya
            $table->string('id_aset'); // Sesuaikan tipe datanya
            $table->decimal('persentase_alokasi', 5, 2)->nullable();
            $table->timestamps();
        });
    }
};