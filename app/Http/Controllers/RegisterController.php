<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Nama_Lengkap' => 'required|string|max:100',
                'Username' => 'required|string|max:100|unique:penyewa,Username',
                'Password' => 'required|string|min:8|confirmed',
                'Email' => [
                    'required',
                    'string',
                    'email',
                    'max:100',
                    'unique:penyewa,Email',
                    function ($attribute, $value, $fail) {
                        $emailValidator = new EmailValidator();
                        $multipleValidations = new MultipleValidationWithAnd([
                            new RFCValidation(),
                            new DNSCheckValidation()
                        ]);

                        if (!$emailValidator->isValid($value, $multipleValidations)) {
                            $fail('Alamat email harus merupakan alamat email yang valid dengan domain yang valid.');
                        }
                    },
                ],
                'NoHP' => 'required|string|max:15',
                'Alamat' => 'required|string|max:300',
                'img_KTP' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'Nama_Lengkap.required' => 'Nama lengkap wajib diisi.',
                'Nama_Lengkap.string' => 'Nama lengkap harus berupa teks.',
                'Nama_Lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
                'Username.required' => 'Username wajib diisi.',
                'Username.string' => 'Username harus berupa teks.',
                'Username.max' => 'Username maksimal 100 karakter.',
                'Username.unique' => 'Username sudah terdaftar.',
                'Password.required' => 'Kata sandi wajib diisi.',
                'Password.string' => 'Kata sandi harus berupa teks.',
                'Password.min' => 'Kata sandi minimal 8 karakter.',
                'Password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
                'Email.required' => 'Alamat email wajib diisi.',
                'Email.string' => 'Alamat email harus berupa teks.',
                'Email.email' => 'Alamat email harus berupa alamat email yang valid.',
                'Email.max' => 'Alamat email maksimal 100 karakter.',
                'Email.unique' => 'Alamat email sudah terdaftar.',
                'NoHP.required' => 'Nomor HP wajib diisi.',
                'NoHP.max' => 'Nomor HP maksimal 15 karakter.',
                'Alamat.required' => 'Alamat wajib diisi.',
                'Alamat.string' => 'Alamat harus berupa teks.',
                'Alamat.max' => 'Alamat maksimal 300 karakter.',
                'img_KTP.required' => 'Foto KTP wajib diunggah.',
                'img_KTP.image' => 'Foto KTP harus berupa gambar.',
                'img_KTP.mimes' => 'Foto KTP harus berupa file dengan format jpeg, png, jpg.',
                'img_KTP.max' => 'Foto KTP maksimal 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validated = $validator->validated();

            if ($request->hasFile('img_KTP')) {
                $image = $request->file('img_KTP');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('ktp_images', $name, 'public');
            }

            Penyewa::create([
                'Nama_Lengkap' => $validated['Nama_Lengkap'],
                'Username' => $validated['Username'],
                'Password' => Hash::make($validated['Password']),
                'Email' => $validated['Email'],
                'NoHP' => $validated['NoHP'],
                'Alamat' => $validated['Alamat'],
                'img_KTP' => $path ?? null,
            ]);

            // Kirim email selamat datang
            Mail::to($validated['Email'])->send(new WelcomeEmail($validated));

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
        } catch (\Exception $e) {
            Log::error('Kesalahan pendaftaran: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Pendaftaran gagal: ' . $e->getMessage());
        }
    }
}
