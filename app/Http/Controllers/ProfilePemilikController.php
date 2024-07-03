<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\VisitorCount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class ProfilePemilikController extends Controller
{
    public function showProfile()
    {
        $pemilik = Auth::guard('pemilik')->user(); // Gunakan guard pemilik
        return view('pemilik/profilepemilik', compact('pemilik'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $pemilik = Auth::guard('pemilik')->user(); // Gunakan guard pemilik

            // Validasi data yang masuk
            $validated = $request->validate([
                'Nama_Lengkap' => 'required|string|max:100',
                'Nama_Kost' => 'required|string|max:270',
                'Username' => 'required|string|max:100|unique:pemilik,Username,' . $pemilik->ID_Pemilik . ',ID_Pemilik',
                'Email' => 'required|string|email|max:100|unique:pemilik,Email,' . $pemilik->ID_Pemilik . ',ID_Pemilik',
                'NoHP' => 'required|string|max:53',
                'Alamat' => 'required|string|max:200',
                'Provinsi' => 'nullable|string|max:100',
                'Kota' => 'nullable|string|max:100',
            ]);

            // Update atribut profil pengguna
            $pemilik->update($validated);

            return redirect()->route('profile.pemilik')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log kesalahan yang terjadi selama proses update
            Log::error('Profile update error: ' . $e->getMessage());

            // Redirect kembali dengan pesan error jika update gagal
            return redirect()->back()->with('error', 'Profil gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function gantiSandi()
    {
        $pemilik = Auth::guard('pemilik')->user(); // Gunakan guard pemilik
        return view('pemilik/profilegantisandi', compact('pemilik'));
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->Password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah'])->withInput();
        }

        $user->Password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('data.penyewa')->with('success', 'Kata sandi berhasil diganti');
    }



    // Bagian untuk manajemen Kamar

    public function indexKamar()
    {
        $pemilik = Auth::guard('pemilik')->user();
        $kamar = Kamar::where('ID_Pemilik', $pemilik->ID_Pemilik)->get();
        return view('pemilik/kamarpemilik', compact('kamar', 'pemilik'));
    }

    public function createKamar()
    {
        $pemilik = Auth::guard('pemilik')->user();
        return view('pemilik/tambahkamar', compact('pemilik'));
    }

    public function storeKamar(Request $request)
    {
        // Log request data for debugging
        Log::info('Request data: ', $request->all());

        $pemilik = Auth::guard('pemilik')->user();
        $request->validate([
            'Keterangan' => 'required|string|max:2000',
            'Harga' => 'required|integer',
            'Fasilitas_Kamar' => 'required|string|max:2000',
            'Fasilitas_Lainnya' => 'required|string|max:2000',
            'img_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Log::info('Request data after validation: ', $request->all());

        $kamar = new Kamar();
        $kamar->Keterangan = $request->Keterangan;
        $kamar->Harga = $request->Harga;
        $kamar->Fasilitas_Kamar = $request->Fasilitas_Kamar;
        $kamar->Fasilitas_Lainnya = $request->Fasilitas_Lainnya;
        $kamar->ID_Pemilik = $pemilik->ID_Pemilik;
        $kamar->Status = 'Tersedia';

        Log::info('Kamar data before saving: ', [
            'Keterangan' => $kamar->Keterangan,
            'Harga' => $kamar->Harga,
            'Fasilitas_Kamar' => $kamar->Fasilitas_Kamar,
            'Fasilitas_Lainnya' => $kamar->Fasilitas_Lainnya,
            'ID_Pemilik' => $kamar->ID_Pemilik,
            'Status' => $kamar->Status,
        ]);

        if ($request->hasFile('img_1')) {
            $kamar->img_1 = $request->file('img_1')->store('kamar_images', 'public');
            Log::info('Image 1 stored at: ', [$kamar->img_1]);
        }

        if ($request->hasFile('img_2')) {
            $kamar->img_2 = $request->file('img_2')->store('kamar_images', 'public');
            Log::info('Image 2 stored at: ', [$kamar->img_2]);
        }

        if ($request->hasFile('img_3')) {
            $kamar->img_3 = $request->file('img_3')->store('kamar_images', 'public');
            Log::info('Image 3 stored at: ', [$kamar->img_3]);
        }

        $kamar->save();

        Log::info('Kamar successfully saved: ', ['ID_Kamar' => $kamar->id]);

        return redirect()->route('kamar.pemilik')->with('success', 'Kamar berhasil ditambahkan.');
    }



    public function editKamar($id)
    {
        $kamar = Kamar::findOrFail($id);
        $pemilik = Auth::guard('pemilik')->user();
        return view('pemilik/editkamar', compact('kamar', 'pemilik'));
    }


    public function updateKamar(Request $request, $id)
    {
        // Log request data for debugging
        Log::info('Update request data: ', $request->all());

        $kamar = Kamar::findOrFail($id);
        $pemilik = Auth::guard('pemilik')->user(); // Fetch pemilik

        // Validate the request data
        $validated = $request->validate([
            'Keterangan' => 'required|string|max:2000',
            'Harga' => 'required|integer',
            'Fasilitas_Kamar' => 'required|string|max:2000',
            'Fasilitas_Lainnya' => 'required|string|max:2000',
            'img_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update images if new files are uploaded
        if ($request->hasFile('img_1')) {
            $image = $request->file('img_1');
            $name = time() . '_1.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('kamar_images', $name, 'public');
            $validated['img_1'] = 'kamar_images/' . $name;

            // Optionally, delete the old image if it exists
            if ($kamar->img_1 && Storage::disk('public')->exists($kamar->img_1)) {
                Storage::disk('public')->delete($kamar->img_1);
            }

            Log::info('Image 1 updated: ', [$validated['img_1']]);
        }

        if ($request->hasFile('img_2')) {
            $image = $request->file('img_2');
            $name = time() . '_2.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('kamar_images', $name, 'public');
            $validated['img_2'] = 'kamar_images/' . $name;

            // Optionally, delete the old image if it exists
            if ($kamar->img_2 && Storage::disk('public')->exists($kamar->img_2)) {
                Storage::disk('public')->delete($kamar->img_2);
            }

            Log::info('Image 2 updated: ', [$validated['img_2']]);
        }

        if ($request->hasFile('img_3')) {
            $image = $request->file('img_3');
            $name = time() . '_3.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('kamar_images', $name, 'public');
            $validated['img_3'] = 'kamar_images/' . $name;

            // Optionally, delete the old image if it exists
            if ($kamar->img_3 && Storage::disk('public')->exists($kamar->img_3)) {
                Storage::disk('public')->delete($kamar->img_3);
            }

            Log::info('Image 3 updated: ', [$validated['img_3']]);
        }

        // Log validated data before saving
        Log::info('Validated data before updating kamar: ', $validated);

        // Update the room with validated data
        $kamar->update($validated);

        Log::info('Kamar successfully updated: ', ['ID_Kamar' => $kamar->id]);

        return redirect()->route('kamar.pemilik')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->Status = $request->status;
        $kamar->save();

        return response()->json(['success' => true], 200);
    }


    public function destroyKamar($id)
    {
        $kamar = Kamar::findOrFail($id);

        // Hapus gambar dari penyimpanan
        Storage::delete('public/' . $kamar->img_1);
        Storage::delete('public/' . $kamar->img_2);
        Storage::delete('public/' . $kamar->img_3);

        $kamar->delete();

        return redirect()->route('kamar.pemilik')->with('success', 'Kamar berhasil dihapus.');
    }



    public function indexPenyewa()
    {
        // Mendapatkan pemilik yang sedang login
        $pemilik = Auth::guard('pemilik')->user();
    
        // Mendapatkan kamar yang dimiliki oleh pemilik
        $kamarIds = Kamar::where('ID_Pemilik', $pemilik->ID_Pemilik)->pluck('ID_Kamar');
    
        // Mendapatkan pemesanan yang berhubungan dengan kamar tersebut
        $penyewas = Pemesanan::whereIn('ID_Kamar', $kamarIds)
            ->with('penyewa') // Memuat relasi penyewa
            ->get()
            ->unique('ID_Penyewa'); // Menghilangkan duplikat penyewa berdasarkan ID_Penyewa
    
        // Mengambil data visitor count harian
        $dailyVisitors = VisitorCount::whereIn('ID_Kamar', $kamarIds)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();
    
        // Mengambil data visitor count bulanan
        $monthlyVisitors = VisitorCount::whereIn('ID_Kamar', $kamarIds)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();
    
        return view('pemilik/daftarpenyewa', compact('pemilik', 'penyewas', 'dailyVisitors', 'monthlyVisitors'));
    }
    
    public function indexTransaksi()
    {
        if (auth()->guard('pemilik')->check()) {
            $pemilik = auth()->guard('pemilik')->user();

            // Ambil semua kamar milik pemilik ini
            $kamars = Kamar::where('ID_Pemilik', $pemilik->ID_Pemilik)->get();

            // Ambil semua pemesanan yang terkait dengan kamar-kamar ini
            $pemesanans = collect();
            foreach ($kamars as $kamar) {
                // Ambil pemesanan yang terkait dengan kamar saat ini
                $pemesanan = Pemesanan::where('ID_Kamar', $kamar->ID_Kamar)->get();
                $pemesanans = $pemesanans->merge($pemesanan);
            }

            $pesan = $pemesanans->isEmpty() ? 'Tidak ada data pemesanan.' : null;

            // Log data pemesanan
            Log::info('Pemesanan:', ['pemesanans' => $pemesanans]);

            return view('pemilik/daftartransaksi', compact('pemilik', 'pesan', 'pemesanans'));
        }
    }

    public function print($orderId)
    {
        $pemesanan = Pemesanan::where('Order_Id', $orderId)->with('kamar.pemilik')->firstOrFail();

        $pdf = PDF::loadView('pemesanan.invoice', compact('pemesanan'));

        return response()->make($pdf->stream(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice_' . $pemesanan->Order_Id . '.pdf"',
        ]);
    }

    public function cetakLaporan()
    {
        $pemesanans = Pemesanan::with('kamar.pemilik')->get();

        $pdf = PDF::loadView('pemilik.laporan', compact('pemesanans'));

        return response()->make($pdf->stream(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan_transaksi.pdf"',
        ]);
    }
}
