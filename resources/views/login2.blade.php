@extends('layouts.master')

@section('title', 'Login')

@section('content')
<style>


.password-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-wrapper input[type="password"],
.password-wrapper input[type="text"] {
    flex: 1;
    padding-right: 30px; /* Space for the eye icon */
}

.password-wrapper i {
    position: absolute;
    right: 15px;
    top: 30%;
    transform: translateY(-50%); /* Posisikan ikon di tengah vertikal */
    cursor: pointer;
    color: #888; 
}
</style>
<div class="login-content">
    <!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <form id="login-form" action="{{ route('login.submit') }}" method="post" onsubmit="return validateForm()">
        @csrf
        <h2>Masuk</h2>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="Username" id="username" placeholder="Masukan Username..." required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" name="Password" id="password" placeholder="Masukan Password..." required>
                <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; margin-left: -30px;"></i>
            </div>
        </div>
        
        <button type="submit" id="login-submit" class="btn">Masuk</button>
        <div class="register-link">
            <h4>Belum Punya Akun? <a href="{{ route('register.form') }}">Daftar</a></h4>
            <h4>Masuk Sebagai Pemilik Kost? <a href="{{ route('login.pemilik') }}"> Masuk</a></h4>
        </div>
        
    </form>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function validateForm() {
    const password = document.getElementById('password').value;
    if (password.length < 8) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Username atau Password Salah atau Tidak Terdaftar. <br>Silahkan Coba Lagi',
            confirmButtonText: 'OK'
        });
        return false; // Mencegah form dari pengiriman
    }
    return true; // Memungkinkan form untuk dikirimkan
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

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function (e) {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
});
</script>
@endsection
