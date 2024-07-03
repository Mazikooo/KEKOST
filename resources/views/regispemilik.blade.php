@extends('layouts.master')

@section('title', 'Register-Pemilik')

@section('content')
<div class="login-content">
    <form id="register-form" action="{{ route('register.submit.pemilik') }}" method="post">
        @csrf
        <h2>Buat Akun Pemilik Kost</h2>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="Username" id="username" placeholder="Masukan Username..." required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="Email" id="email" placeholder="Masukan Email..." required>
        </div>
        <div class="mb-3">
            <label for="name">Nama Lengkap Pemilik</label>
            <input type="text" name="Nama_Lengkap" id="name" placeholder="Masukan Nama Lengkap..." required>
        </div>
        <div class="mb-3">
            <label for="name">Nama Kost</label>
            <input type="text" name="Nama_Kost" id="name" placeholder="Masukan Nama Kost..." required>
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
            <input type="text" name="NoHP" id="phone" placeholder="Masukan No HP..." required>
        </div>
        <div class="mb-3">
    <label for="Provinsi">Pilih Provinsi</label>
    <select id="Provinsi" name="Provinsi" class="form-control" required>
        <option value="">Pilih Provinsi</option>
    </select>
</div>
<div class="mb-3">
    <label for="Kota">Pilih Kota</label>
    <select id="Kota" name="Kota" class="form-control" required>
        <option value="">Pilih Kota</option>
    </select>
</div>
<div class="mb-3">
    <label for="address">Alamat</label>
    <input type="text" name="Alamat" id="address" placeholder="Masukan Alamat Lengkap..." required>
</div>

<button type="submit" id="register-submit" class="btn" onclick="return validateForm()">Buat</button>
<div class="register-link">
    <h4>Sudah Punya Akun? <a href="{{ route('login') }}">Masuk</a></h4>
</div>
</form>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const apiKey = 'd58f59a4b80e8baa28486e5527cb882175c373683a457c955cf8cd8e91e4773e';

    // Load provinces on page load
    $.ajax({
        url: `https://api.binderbyte.com/wilayah/provinsi?api_key=${apiKey}`,
        method: 'GET',
        success: function(data) {
            if (data.code === "200") {
                console.log('Provinces loaded:', data.value); // Logging for debugging
                $('#Provinsi').append('<option value="" data-id="">Pilih Provinsi</option>');
                $.each(data.value, function(key, value) {
                    $('#Provinsi').append('<option value="'+ value.name +'" data-id="'+ value.id +'">'+ value.name +'</option>');
                });
            } else {
                console.error('Failed to load provinces:', data.messages); // Logging error
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText); // Logging error response text
        }
    });

    // Load cities when a province is selected
    $('#Provinsi').change(function() {
        var provinceName = $(this).val();
        var provinceID = $(this).find(':selected').data('id');
        if (provinceName && provinceID) {
            $.ajax({
                url: `https://api.binderbyte.com/wilayah/kabupaten?api_key=${apiKey}&id_provinsi=${provinceID}`,
                method: 'GET',
                success: function(data) {
                    if (data.code === "200") {
                        console.log('Cities loaded for province', provinceName, ':', data.value); // Logging for debugging
                        $('#Kota').empty().append('<option value="">Pilih Kota</option>');
                        $.each(data.value, function(key, value) {
                            $('#Kota').append('<option value="'+ value.name +'">'+ value.name +'</option>');
                        });
                    } else {
                        console.error('Failed to load cities:', data.messages); // Logging error
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText); // Logging error response text
                }
            });
        } else {
            $('#Kota').empty().append('<option value="">Pilih Kota</option>');
        }
    });
});


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
