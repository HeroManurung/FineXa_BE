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
        Schema::create('financial_profiles', function (Blueprint $table) {
            $table->id('id_profil');
            $table->unsignedBigInteger('id_user')->unique(); 
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('sumber_pendapatan'); 
            $table->decimal('nominal_pendapatan', 15, 2); 
            $table->string('persentase_tabungan'); 
            $table->string('perilaku_belanja'); 
            $table->string('tipe_investor'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_profiles');
    }
};
