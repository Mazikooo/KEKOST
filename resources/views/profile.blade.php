@extends('layouts.master')

@section('title', 'Profil')

@section('content-profil')
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">


            <!--    <img src="path_to_image" alt="Profile Image" class="profile-image">
         -->
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
        <h3>Lihat/Edit Profil</h3>
        <form id="profile-form" action="{{ route('profile.update', ['ID_Penyewa' => $penyewa->ID_Penyewa]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="Nama_Lengkap">Nama Lengkap</label>
                <input type="text" name="Nama_Lengkap" id="Nama_Lengkap" value="{{ $penyewa->Nama_Lengkap }}" required>
            </div>
            <div class="mb-3">
                <label for="Username">Username</label>
                <input type="text" name="Username" id="Username" value="{{ $penyewa->Username }}" required>
            </div>
            <div class="mb-3">
                <label for="Email">Email</label>
                <input type="email" name="Email" id="Email" value="{{ $penyewa->Email }}" required>
            </div>
            <div class="mb-3">
                <label for="NoHP">No HP</label>
                <input type="text" name="NoHP" id="NoHP" value="{{ $penyewa->NoHP }}" required>
            </div>


            <div class="mb-3">
                <label for="Alamat">Alamat</label>
                <input type="text" name="Alamat" id="Alamat" value="{{ $penyewa->Alamat }}" required>
            </div>

            <div class="mb-3">
                <label for="foto_ktp">Foto KTP</label>
                <img src="{{ asset('storage/' . $penyewa->img_KTP) }}" alt="Foto KTP" style="max-width: 30%; height: auto; margin-top: 10px; border: 2px solid #bdc3c7; border-radius: 6px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <input type="file" name="img_KTP" id="ktpp" accept="image/*" onchange="previewKTPImage(event)">
                @if($penyewa->img_KTP)
                <img id="ktp-preview" src="{{ asset('storage/' . $penyewa->img_KTP) }}" alt="KTP Preview" style="max-width: 200px; height: auto; margin-top: 10px;" />
                @else
                <img id="ktp-preview" src="#" alt="KTP Preview" style="display:none; max-width: 200px; height: auto; margin-top: 10px;" />
                @endif
            </div>



            <button type="submit" id="profile-submit" class="btn" disabled>Simpan Perubahan</button>
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

        const form = document.getElementById('profile-form');
        const submitButton = document.getElementById('profile-submit');
        const initialFormState = new FormData(form);

        form.addEventListener('input', function() {
            const currentFormState = new FormData(form);
            let formChanged = false;

            for (const [key, value] of initialFormState.entries()) {
                if (currentFormState.get(key) !== value) {
                    formChanged = true;
                    break;
                }
            }

            submitButton.disabled = !formChanged;
        });
    });

    function previewKTPImage(event) {
        const input = event.target;
        const preview = document.getElementById('ktp-preview');
        const reader = new FileReader();

        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
@endsection