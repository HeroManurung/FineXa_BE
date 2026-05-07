<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';
    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'kategori',
        'pertanyaan',
        'jawaban'
    ];
}