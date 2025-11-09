<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable; // library yang menyimpan fitur seperti login/logout,  otorisasi, dan password manipulation
use Illuminate\Notifications\Notifiable;

// tidak harus extend Model yang penting berada pada folder model
class Mahasiswa extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "mahasiswa_models"; // karena membuat model dengan perintah php artisan make:model MahasiswaModel -mfs maka table tersebut hasilnya dibuat secara default

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
