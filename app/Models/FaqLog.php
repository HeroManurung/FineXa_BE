<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqLog extends Model
{
    use HasFactory;

    // Izinkan Laravel mengisi dua kolom ini
    protected $fillable = ['faq_id', 'user_id'];
}