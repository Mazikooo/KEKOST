<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penyewa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'penyewa';
    protected $primaryKey = 'ID_Penyewa';
    public $incrementing = true; // Ensure it's set to auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Lengkap',
        'Username',
        'Password',
        'Email',
        'NoHP',
        'Alamat',
        'img_KTP',
    ];

    protected $hidden = [
        'Password',
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'authable');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'ID_Penyewa', 'ID_Penyewa');
    }

}
