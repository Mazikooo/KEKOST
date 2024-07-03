<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni'; // Sesuaikan dengan nama tabel yang Anda gunakan

    protected $primaryKey = 'ID_Testimoni'; // Tentukan primary key yang benar

    protected $fillable = ['Username', 'Rating', 'Pesan', 'ID_Kamar', 'ID_Penyewa'];

    // Definisikan relasi dengan model Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'ID_Kamar');
    }

    // Definisikan relasi dengan model Penyewa
    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'ID_Penyewa');
    }
}

