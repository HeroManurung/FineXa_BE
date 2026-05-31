<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('faq_logs', function (Blueprint $table) {
            $table->id();
            // Menyimpan ID FAQ apa yang sedang dibaca
            $table->unsignedBigInteger('faq_id');
            // Menyimpan ID siapa yang baca (nullable jika aplikasimu bisa diakses tanpa login)
            $table->unsignedBigInteger('user_id')->nullable();
            // Otomatis membuat kolom created_at (waktu klik) dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_logs');
    }
};
