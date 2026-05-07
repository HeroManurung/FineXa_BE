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
        Schema::create('profile_challenges', function (Blueprint $table) {
            $table->unsignedBigInteger('id_profil');
            $table->unsignedBigInteger('id_tantangan');
            $table->primary(['id_profil', 'id_tantangan']);
            $table->foreign('id_profil')->references('id_profil')->on('financial_profiles')->onDelete('cascade');
            $table->foreign('id_tantangan')->references('id_tantangan')->on('master_challenges')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_challenges');
    }
};
