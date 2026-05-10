<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Faq extends Model
{
    use HasFactory;
    protected $table = 'faqs';
    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'kategori',
        'pertanyaan',
        'jawaban'
    ];
}