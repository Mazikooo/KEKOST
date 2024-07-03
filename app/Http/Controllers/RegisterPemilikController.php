<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class RegisterPemilikController extends Controller
{
    public function showRegistrationForm()
    {
        return view('regispemilik');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'Nama_Lengkap' => 'required|string|max:100',
                'Nama_Kost' => 'required|string|max:270',
                'Username' => 'required|string|max:100|unique:pemilik,Username',
                'Email' => 'required|string|email|max:100|unique:pemilik,Email',
                'Password' => 'required|string|min:8|confirmed',
                'NoHP' => 'required|string|max:53',
                'Alamat' => 'required|string|max:300',
                'Provinsi' => 'required|string|max:200',
                'Kota' => 'required|string|max:200',
            ]);

            Pemilik::create([
                'Nama_Lengkap' => $validated['Nama_Lengkap'],
                'Nama_Kost' => $validated['Nama_Kost'],
                'Username' => $validated['Username'],
                'Email' => $validated['Email'],
                'Password' => Hash::make($validated['Password']),
                'NoHP' => $validated['NoHP'],
                'Alamat' => $validated['Alamat'],
                'Provinsi' => $validated['Provinsi'],
                'Kota' => $validated['Kota'],
            ]);

            return redirect()->route('login.pemilik')->with('success', 'Registration successful. Please login.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
