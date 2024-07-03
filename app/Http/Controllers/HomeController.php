<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Kamar;
use App\Models\Pemilik;
use App\Models\Testimoni;
use App\Models\VisitorCount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with('pemilik')
            ->where('Status', 'Tersedia') 
            ->orderBy('ID_Kamar', 'desc')
            ->get();

        return view('layouts.home', compact('kamars'));
    }

    public function detailKamar($id)
    {
        $kamar = Kamar::with('pemilik')->findOrFail($id);

        $testimonis = Testimoni::where('ID_Kamar', $id)->orderBy('ID_Testimoni', 'desc')->get();

        // Simpan data kunjungan ke tabel visitor_count
        VisitorCount::create([
            'ID_Kamar' => $kamar->ID_Kamar,
            'ID_Pemilik' => $kamar->ID_Pemilik,
        ]);

        return view('detailKamar', compact('kamar', 'testimonis'));
    }
}
