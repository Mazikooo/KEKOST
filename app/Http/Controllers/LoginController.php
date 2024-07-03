<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login2');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'Username' => 'required|string|max:100',
            'Password' => 'required|string|min:8',
        ]);

        $penyewa = Penyewa::where('Username', $validated['Username'])->first();

        if ($penyewa && Hash::check($validated['Password'], $penyewa->Password)) {
            Auth::guard('penyewa')->login($penyewa);
            return redirect()->route('home')->with('success', 'Kamu Berhasil Masuk');
        } else {
            return redirect()->back()->with('error', 'Username atau Password Salah atau Tidak Terdaftar. Silahkan Coba Lagi');
        }
    }

    public function logout()
    {
        Auth::guard('penyewa')->logout();
        // Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu Berhasil Keluar');
    }
}
