<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialProfile extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya sesuai
    protected $table = 'financial_profiles'; 
    protected $primaryKey = 'id_profil';

    // Update daftar VIP sesuai dengan kolom baru di Migration tadi
    protected $fillable = [
        'id_user', // Atau 'user_id', sesuaikan dengan foreign key-mu
        'skor_waktu', 
        'skor_risiko', 
        'skor_kapasitas', 
        'skor_hutang', 
        'skor_pengetahuan', 
        'total_poin',
        'profil_risiko', 
        'persen_saham', 
        'persen_pasar_uang', 
        'persen_obligasi', 
        'persen_campuran'
    ];


    public function user(){
    return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    
    
}