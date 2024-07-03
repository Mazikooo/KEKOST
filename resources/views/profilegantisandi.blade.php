@extends('layouts.master')

@section('title', 'Ganti Kata Sandi')

@section('content-profil')
<style>
    .footer{
        margin-top:auto !important;
    }
    .profile-content{
        margin-bottom: 200px !important;
    }
</style>
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">
            <h2>{{ $penyewa->Nama_Lengkap }}</h2>
            <p>{{ $penyewa->Email }}</p>
        </div>
        <ul class="profile-menu">
            <li><a href="{{ route('profile') }}">Profil</a></li>
            <li><a href="{{ route('menu.booking') }}">Booking</a></li>
            <li><a href="{{ route('profile.gantiSandi') }}">Ganti Kata Sandi</a></li>
            <li><a href="#" id="logout-link">Keluar</a></li>
        </ul>
    </div>
    <div class="profile-content">
        <h3>Ganti Kata Sandi</h3>
        <form id="change-password-form" action="{{ route('profile.changePassword') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="current_password">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" id="current_password" required>
                @if ($errors->has('current_password'))
                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="new_password">Kata Sandi Baru</label>
                <input type="password" name="new_password" id="new_password" required>
                @if ($errors->has('new_password'))
                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                @if ($errors->has('new_password_confirmation'))
                <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                @endif
            </div>
            <button type="submit" class="btn">Ganti Kata Sandi</button>
        </form>
    </div>
</div>

<!-- Formulir Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

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