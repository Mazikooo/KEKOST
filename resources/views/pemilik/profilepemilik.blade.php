@extends('layouts.master')

@section('title', 'Profil-pemilik')

@section('content-profil')
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">
            <!-- Uncomment if you have a profile image -->
            <!-- <img src="path_to_image" alt="Profile Image" class="profile-image"> -->
            <h2>{{ $pemilik->Nama_Kost }}</h2>
            <p>{{ $pemilik->Email }}</p>
        </div>
        <ul class="profile-menu">
            <li><a href="{{ route('profile.pemilik') }}">Profil</a></li>
            <li><a href="{{ route('kamar.pemilik') }}">Kamar</a></li>
            <li><a href="{{ route('data.penyewa') }}">Penyewa</a></li>
            <li><a href="{{ route('data.transaksi') }}">Transaksi</a></li>
            <li><a href="{{ route('profile.gantiSandi.pemilik') }}">Ganti Kata Sandi</a></li>
            <li><a href="#" id="logout-link">Keluar</a></li>
        </ul>
    </div>
    <div class="profile-content">
        <h3>Lihat/Edit Profil</h3>
        <form id="profile-form" action="{{ route('profile.update.pemilik', ['ID_Pemilik' => $pemilik->ID_Pemilik]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="Nama_Lengkap">Nama Lengkap</label>
                <input type="text" name="Nama_Lengkap" id="Nama_Lengkap" value="{{ $pemilik->Nama_Lengkap }}" required>
            </div>
            <div class="mb-3">
                <label for="Nama_Kost">Nama Kost</label>
                <input type="text" name="Nama_Kost" id="Nama_Kost" value="{{ $pemilik->Nama_Kost }}" required>
            </div>
            <div class="mb-3">
                <label for="Username">Username</label>
                <input type="text" name="Username" id="Username" value="{{ $pemilik->Username }}" required>
            </div>
            <div class="mb-3">
                <label for="Email">Email</label>
                <input type="email" name="Email" id="Email" value="{{ $pemilik->Email }}" required>
            </div>
            <div class="mb-3">
                <label for="NoHP">No HP</label>
                <input type="text" name="NoHP" id="NoHP" value="{{ $pemilik->NoHP }}" required>
            </div>
            <div class="mb-3">
                <label for="Alamat">Alamat Lengkap</label>
                <input type="text" name="Alamat" id="Alamat" value="{{ $pemilik->Alamat }}" required>
            </div>
            <div class="mb-3">
                <label for="Provinsi">Provinsi</label>
                <select id="Provinsi" name="Provinsi" class="form-control" required>
                    <option value="">{{ $pemilik->Provinsi }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Kota">Kota</label>
                <select id="Kota" name="Kota" class="form-control" required>
                    <option value="">{{ $pemilik->Kota }}</option>
                </select>
            </div>
            <button type="submit" id="profile-submit" class="btn" disabled>Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- Formulir Logout -->
<form id="logout-form" action="{{ route('logout.pemilik') }}" method="POST" style="display: none;">
    @csrf
</form>

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
                $('#Provinsi').empty().append('<option value="">{{ $pemilik->Provinsi }}</option>');
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
        var provinceID = $(this).find(':selected').data('id');
        if (provinceID) {
            $.ajax({
                url: `https://api.binderbyte.com/wilayah/kabupaten?api_key=${apiKey}&id_provinsi=${provinceID}`,
                method: 'GET',
                success: function(data) {
                    if (data.code === "200") {
                        console.log('Cities loaded for province ID', provinceID, ':', data.value); // Logging for debugging
                        $('#Kota').empty().append('<option value="">{{ $pemilik->Kota }}</option>');
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
            $('#Kota').empty().append('<option value="">{{ $pemilik->Kota }}</option>');
        }
    });

    // Logout functionality
    document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

    // Form submission
    const form = document.getElementById('profile-form');
    const submitButton = document.getElementById('profile-submit');
    const initialFormState = new FormData(form);

    form.addEventListener('input', function() {
        const currentFormState = new FormData(form);
        let formChanged = false;

        for (const [key, value] of initialFormState.entries()) {
            if (currentFormState.get(key) !== value) {
                formChanged =true;
                break;
            }
        }

        submitButton.disabled = !formChanged;
    });
});
</script>
@endsection

