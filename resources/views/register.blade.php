@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="login-content">
    <form id="register-form" action="{{ route('register.submit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h2>Buat Akun</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="Nama_Lengkap" id="name" value="{{ old('Nama_Lengkap') }}" placeholder="Masukan Nama Lengkap..." required>
        </div>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="Username" id="username" value="{{ old('Username') }}" placeholder="Masukan Username..." required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="Email" id="email" value="{{ old('Email') }}" placeholder="Masukan Email..." required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="Password" id="password" placeholder="Masukan Password..." required>
        </div>
        <div class="mb-3">
            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" name="Password_confirmation" id="confirm_password" placeholder="Masukan Konfirmasi Password..." required>
        </div>
        <div class="mb-3">
            <label for="phone">Nomor HP</label>
            <input type="text" name="NoHP" id="phone" value="{{ old('NoHP') }}" placeholder="Masukan No HP..." required>
        </div>
        <div class="mb-3">
            <label for="address">Alamat</label>
            <input type="text" name="Alamat" id="address" value="{{ old('Alamat') }}" placeholder="Masukan Alamat..." required>
        </div>
        <div class="mb-3">
            <label for="ktp">Foto KTP</label>
            <input type="file" name="img_KTP" id="ktp" accept="image/*" required onchange="previewKTPImage(event)">
            <img id="ktp-preview" src="#" alt="KTP Preview" style="display:none; max-width: 200px; height: auto; margin-top: 10px;" />
        </div>
        
        <button type="submit" id="register-submit" class="btn" onclick="return validateForm()">Buat</button>
        <div class="register-link">
            <h4>Sudah Punya Akun? <a href="{{ route('login') }}">Masuk</a></h4>
        </div>
    </form>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function previewKTPImage(event) {
    const ktpPreview = document.getElementById('ktp-preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            ktpPreview.src = e.target.result;
            ktpPreview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    } else {
        ktpPreview.src = '#';
        ktpPreview.style.display = 'none';
    }
}

function validateForm() {
    // Mendapatkan semua elemen input dalam formulir
    var inputs = document.querySelectorAll('#register-form input[required]');
    // Iterasi melalui semua input
    for (var i = 0; i < inputs.length; i++) {
        // Jika ada input yang kosong
        if (inputs[i].value.trim() === '') {
            // Dapatkan label yang terkait dengan input ini
            var label = document.querySelector('label[for="' + inputs[i].id + '"]').innerText;
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: label + ' harus diisi',
                confirmButtonText: 'OK'
            });
            return false; // Menghentikan pengiriman formulir
        }
    }

    // Cek email harus mengandung "@"
    var emailInput = document.getElementById('email');
    if (!emailInput.value.includes('@')) {
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: 'Email harus sesuai dengan format yang benar (harus mengandung "@")',
            confirmButtonText: 'OK'
        });
        return false; // Menghentikan pengiriman formulir
    }

    return true; // Melanjutkan pengiriman formulir jika semua input terisi
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
@endsection
