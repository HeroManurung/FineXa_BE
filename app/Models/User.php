<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    

    public function financialProfile(){
    // User memiliki satu Financial Profile
    return $this->hasOne(FinancialProfile::class, 'id_user', 'id_user');
    }


    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Membelokkan link Lupa Password agar mengarah ke frontend ReactJS
     */
    public function sendPasswordResetNotification($token)
    {
        // Sesuaikan url ini dengan alamat ReactJS kalian yang ada di foto tadi
        $url = 'http://localhost:5173/atur-ulang-password?token=' . $token . '&email=' . urlencode($this->email);

        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($url));
    }

}