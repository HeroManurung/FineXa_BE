<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'nama_aset', 
        'kategori_aset', 
        'tingkat_risiko'
    ];
}