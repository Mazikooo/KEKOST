<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'Pemesanan';
    protected $primaryKey = 'ID_Pemesanan';
    public $timestamps = false;

    protected $fillable = [
        'Tgl_Pemesanan',
        'Durasi_sewa',
        'Tgl_mulai_sewa',
        'Tgl_habis_sewa',
        'Total_harga',
        'ID_Penyewa',
        'ID_Kamar',
        'Nama_Lengkap',
        'Email',
        'NoHP',
        'Order_Id',
        'status_pembayaran',
        'metode_bayar',
    ];

    // Relasi dengan Penyewa
    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'ID_Penyewa', 'ID_Penyewa'); // Sesuaikan nama kolom
    }

    // Relasi dengan Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'ID_Kamar');
    }
}
