<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pemilik extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pemilik';
    protected $primaryKey = 'ID_Pemilik';
    public $incrementing = true; // Ensure it's set to auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Lengkap',
        'Nama_Kost',
        'Username',
        'Password',
        'Email',
        'NoHP',
        'Alamat',
        'Provinsi',
        'Kota',
    ];

    protected $hidden = [
        'Password',
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'authable');
    }
}
