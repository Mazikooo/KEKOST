<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Pemesanan;
use App\Models\Testimoni;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $penyewa = Auth::guard('penyewa')->user(); // Gunakan guard penyewa
        return view('profile', compact('penyewa'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $penyewa = Auth::guard('penyewa')->user(); // Gunakan guard penyewa

            // Validate the incoming request data
            $validated = $request->validate([
                'Nama_Lengkap' => 'required|string|max:100',
                'Username' => 'required|string|max:100|unique:penyewa,Username,' . $penyewa->ID_Penyewa . ',ID_Penyewa',
                'Email' => 'required|string|email|max:100|unique:penyewa,Email,' . $penyewa->ID_Penyewa . ',ID_Penyewa',
                'NoHP' => 'required|string|max:55',
                'Alamat' => 'required|string|max:300',
                'img_KTP' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, only validate if provided
            ]);

            if ($request->hasFile('img_KTP')) {
                $image = $request->file('img_KTP');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('ktp_images', $name, 'public');
                $validated['img_KTP'] = 'ktp_images/' . $name;

                // Optionally, delete the old KTP image if it exists
                if ($penyewa->img_KTP && Storage::disk('public')->exists($penyewa->img_KTP)) {
                    Storage::disk('public')->delete($penyewa->img_KTP);
                }
            }

            // Update the user's profile attributes
            $penyewa->update($validated);

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log any errors that occur during the update process
            Log::error('Profile update error: ' . $e->getMessage());

            // Redirect back with error message if update fails
            return redirect()->back()->with('error', 'Profil gagal diperbarui: ' . $e->getMessage());
        }
    }



    public function showBooking()
    {
        if (auth()->guard('penyewa')->check()) {
            $penyewa = auth()->guard('penyewa')->user();

            // Log detail user yang sedang login
            Log::info('Penyewa yang sedang login:', ['penyewa' => $penyewa]);

            $pemesanan = Pemesanan::where('ID_Penyewa', $penyewa->ID_Penyewa)->get();

            // Log data pemesanan
            Log::info('Pemesanan:', ['pemesanan' => $pemesanan]);

            $pesan = $pemesanan->isEmpty() ? 'Tidak ada data pemesanan.' : null;

            return view('menubooking', compact('penyewa', 'pemesanan', 'pesan'));
        }

        // Jika user tidak login, alihkan ke halaman login
        Log::info('Pengguna tidak login atau bukan penyewa.');
        return redirect()->route('login');
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

    
    public function testimoni(Request $request)
    {

        $penyewa = auth()->guard('penyewa')->user();

        // Validasi data yang diterima dari form
        $request->validate([
            'Rating' => 'required|integer|min:1|max:5',
            'Pesan' => 'required|string|max:500',
            'ID_Kamar' => 'required|integer',
        ]);

        // Log data yang diterima untuk debugging
        Log::info('Data yang diterima:', [
            'Username' => $penyewa->Username,
            'Rating' => $request->Rating,
            'Pesan' => $request->Pesan,
            'ID_Kamar' => $request->ID_Kamar,
            'ID_Penyewa' => $penyewa->ID_Penyewa,
        ]);

        // Simpan testimoni ke dalam database
        $testimoni = Testimoni::create([
            'Username' => $penyewa->Username,
            'Rating' => $request->Rating,
            'Pesan' => $request->Pesan,
            'ID_Kamar' => $request->ID_Kamar,
            'ID_Penyewa' => $penyewa->ID_Penyewa,
        ]);

        // Log hasil penyimpanan
        Log::info('Ulasan yang disimpan:', $testimoni->toArray());

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Ulasan berhasil disimpan.');
    }


    public function testimonidlt($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        if ($testimoni->ID_Penyewa != auth()->guard('penyewa')->user()->ID_Penyewa) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan untuk menghapus testimoni ini.');
        }
        $testimoni->delete();
        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }


    public function gantiSandi()
    {
        $penyewa = Auth::guard('penyewa')->user();
        return view('profilegantisandi', compact('penyewa'));
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

        return redirect()->route('profile')->with('success', 'Kata sandi berhasil diganti');
    }
}
