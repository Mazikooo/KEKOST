<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Kamar;
use App\Models\Pemilik;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CariKamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with('pemilik')
            ->where('Status', 'Tersedia') // Filter to only include rooms with status "Tersedia"
            ->orderBy('ID_Kamar', 'desc')
            ->get();

        return view('carikamar', compact('kamars'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $kamars = Kamar::with('pemilik')
            ->where('Status', 'Tersedia') // Filter to only include rooms with status "Tersedia"
            ->where(function ($query) use ($keyword) {
                $query->whereHas('pemilik', function ($subQuery) use ($keyword) {
                    $subQuery->where('Nama_Kost', 'like', "%$keyword%")
                        ->orWhere('Kota', 'like', "%$keyword%");
                })
                    ->orWhere('Harga', 'like', "%$keyword%");
            })
            ->orderBy('ID_Kamar', 'desc')
            ->get();

        return view('search_results', compact('kamars'));
    }


    public function detailKamar($id)
    {
        $kamar = Kamar::with('pemilik')->findOrFail($id);
        return view('detailKamar', compact('kamar'));
    }

    public function Sewa($id)
    {
        $penyewa = Auth::guard('penyewa')->user();
        $kamar = Kamar::with('pemilik')->findOrFail($id);
        return view('sewa', compact('kamar', 'penyewa'));
    }

    public function storeSewa(Request $request)
    {
        $request->validate([
            'tgl_pemesanan' => 'required|date',
            'durasi_sewa' => 'required|string|max:200',
            'tgl_mulai_sewa' => 'required|date',
            'tgl_habis_sewa' => 'required|date',
            'total_harga' => 'required|string|max:200',
            'id_penyewa' => 'required|integer|exists:penyewa,ID_Penyewa',
            'id_kamar' => 'required|integer|exists:kamar,ID_Kamar',
        ]);

        try {
            $pemesanan = new Pemesanan();
            $pemesanan->Tgl_Pemesanan = $request->tgl_pemesanan;
            $pemesanan->Durasi_sewa = $request->durasi_sewa;
            $pemesanan->Tgl_mulai_sewa = $request->tgl_mulai_sewa;
            $pemesanan->Tgl_habis_sewa = $request->tgl_habis_sewa;
            $pemesanan->Total_harga = $request->total_harga;
            $pemesanan->ID_Penyewa = $request->id_penyewa;
            $pemesanan->ID_Kamar = $request->id_kamar;
            $pemesanan->save();

            return redirect()->back()->with('success', 'Pemesanan berhasil dilakukan!');
        } catch (\Exception $e) {
            Log::error('Error while storing pemesanan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan pemesanan. Silakan coba lagi.');
        }
    }
}
