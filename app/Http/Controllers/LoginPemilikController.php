<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginPemilikController extends Controller
{
    public function showLoginForm()
    {
        return view('loginpemilik');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'Username' => 'required|string|max:100',
            'Password' => 'required|string|min:8',
        ]);

        $pemilik = Pemilik::where('Username', $validated['Username'])->first();

        if ($pemilik && Hash::check($validated['Password'], $pemilik->Password)) {
            Auth::guard('pemilik')->login($pemilik);
            return redirect()->route('home')->with('success', 'Kamu Berhasil Masuk');
        } else {
            return redirect()->back()->with('error', 'Username atau Password Salah atau Tidak Terdaftar. Silahkan Coba Lagi');
        }
    }

    public function logout()
    {
        Auth::guard('pemilik')->logout();
        return redirect()->route('login.pemilik')->with('success', 'Kamu Berhasil Keluar');
    }
}
