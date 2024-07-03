<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'ID_Kamar';

    protected $fillable = [
        'Keterangan',
        'Harga',
        'Fasilitas_Kamar',
        'Fasilitas_Lainnya',
        'img_1',
        'img_2',
        'img_3',
        'Status',
        'ID_Pemilik',
        'visitor_count',
    ];

    // Relasi ke model Pemilik
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'ID_Pemilik', 'ID_Pemilik');
    }
}
