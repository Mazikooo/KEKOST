@extends('layouts.master')

@section('title', 'Profil-pemilik')

@section('content-profil')
<style>
    .preview-container {
        display: flex;
        gap: 10px;
    }

    .preview {
        max-width: 30%;
        height: auto;
        margin-top: 10px;
        border: 0px solid #bdc3c7;
        border-radius: 6px;
        box-shadow: 0 0px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-container {
        display: flex;
    }

    .profile-sidebar {
        flex: 1;
        padding: 20px;
        border-right: 1px solid #ddd;
    }

    .profile-content {
        flex: 3;
        padding: 20px;
    }


    /* Style Checkbox */
    .small-checkbox .form-check-input {
        width: 15px;
        height: 15px;
        margin-right: 5px;
        position: relative;
    }

    .small-checkbox .form-check-label {
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }

    .small-checkbox {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 5px;
    }

    .form-check {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        margin-right: 5px;
        display: none;
        /* Hide the default checkbox */
    }

    .form-check-label {
        margin-bottom: 0;
        align-items: center;
        font-weight: 500 !important;
        cursor: pointer;
        /* Add pointer cursor */
    }

    /* Checkbox Custom Style */
    .checkbox-wrapper-37 .checkbox-svg {
        width: 15px;
        /* Adjust the size to match form */
        height: 15px;
        /* Adjust the size to match form */
        margin-right: 5px;
    }

    .checkbox-wrapper-37 .checkbox-box {
        fill: #fff;
        stroke: #ff7a00;
        stroke-dasharray: 800;
        stroke-dashoffset: 800;
        transition: stroke-dashoffset 0.6s ease-in;
    }

    .checkbox-wrapper-37 .checkbox-tick {
        stroke: #ff7a00;
        stroke-dasharray: 172;
        stroke-dashoffset: 172;
        transition: stroke-dashoffset 0.6s ease-in;
    }

    .checkbox-wrapper-37 input[type="checkbox"]:checked+.terms-label .checkbox-box,
    .checkbox-wrapper-37 input[type="checkbox"]:checked+.terms-label .checkbox-tick {
        stroke-dashoffset: 0;
    }

    .fasilitas-info {
        margin-top: -10px;

    }
</style>
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">
            <h2>{{ $pemilik->Nama_Lengkap }}</h2>
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
        <h2>Tambah Kamar Baru</h2>
        <form id="kamar-form" action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="Keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="Keterangan" name="Keterangan" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="Fasilitas_Kamar" class="form-label">Fasilitas Kamar</label>
                <p class="fasilitas-info">*klik untuk memilih fasilitas yang tersedia di Kost Anda.</p>

                <div class="small-checkbox checkbox-wrapper-37">
                    @foreach(['AC', 'Lemari', 'Meja/Kursi', 'Kasur', 'Kamar Mandi Dalam', 'Kamar Mandi Luar'] as $fasilitas)
                    <div class="form-check">
                        <input class="form-check-input fasilitas-kamar" type="checkbox" value="{{ $fasilitas }}" id="fasilitas_kamar_{{ $loop->index }}">
                        <label class="terms-label form-check-label" for="fasilitas_kamar_{{ $loop->index }}">
                            <svg class="checkbox-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="path-1-inside-1_476_5-37" fill="white">
                                    <rect width="200" height="200" />
                                </mask>
                                <rect width="200" height="200" class="checkbox-box" stroke-width="40" mask="url(#path-1-inside-1_476_5-37)" />
                                <path class="checkbox-tick" d="M52 111.018L76.9867 136L149 64" stroke-width="15" />
                            </svg>
                            <span class="label-text">{{ $fasilitas }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" id="Fasilitas_Kamar" name="Fasilitas_Kamar" required>
            </div>

            <div class="mb-3">
                <label for="Fasilitas_Lainnya" class="form-label">Fasilitas Lainnya</label>
                <p class="fasilitas-info">*klik untuk memilih fasilitas yang tersedia di Kost Anda.</p>

                <div class="small-checkbox checkbox-wrapper-37">
                    @foreach(['Dapur Bersama', 'Laundry', 'WiFi', 'Parkiran', 'Ruang Tamu/Ruang Tunggu', 'CCTV', 'Satpam 24Jam', 'Jasa Cleaning Service', 'Gym', 'Area Santai', 'Kantin/Pujasera'] as $fasilitas)
                    <div class="form-check">
                        <input class="form-check-input fasilitas-lainnya" type="checkbox" value="{{ $fasilitas }}" id="fasilitas_lainnya_{{ $loop->index }}">
                        <label class="terms-label form-check-label" for="fasilitas_lainnya_{{ $loop->index }}">
                            <svg class="checkbox-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="path-1-inside-1_476_5-37" fill="white">
                                    <rect width="200" height="200" />
                                </mask>
                                <rect width="200" height="200" class="checkbox-box" stroke-width="40" mask="url(#path-1-inside-1_476_5-37)" />
                                <path class="checkbox-tick" d="M52 111.018L76.9867 136L149 64" stroke-width="15" />
                            </svg>
                            <span class="label-text">{{ $fasilitas }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" id="Fasilitas_Lainnya" name="Fasilitas_Lainnya" required>
            </div>


            <div class="mb-3">
                <label for="Harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="Harga" name="Harga" required>
            </div>

            <div class="mb-3">
                <label for="img_1" class="form-label">Gambar 1</label>
                <input class="form-control" type="file" id="img_1" name="img_1" accept="image/*" required>
                <div id="preview_1" class="preview-container"></div>
            </div>
            <div class="mb-3">
                <label for="img_2" class="form-label">Gambar 2</label>
                <input class="form-control" type="file" id="img_2" name="img_2" accept="image/*" required>
                <div id="preview_2" class="preview-container"></div>
            </div>
            <div class="mb-3">
                <label for="img_3" class="form-label">Gambar 3</label>
                <input class="form-control" type="file" id="img_3" name="img_3" accept="image/*" required>
                <div id="preview_3" class="preview-container"></div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kamar</button>
        </form>
    </div>
</div>

<!-- Formulir Logout -->
<form id="logout-form" action="{{ route('logout.pemilik') }}" method="POST" style="display: none;">
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

        const form = document.getElementById('kamar-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            let errors = [];

            // Validate Keterangan
            const keterangan = document.getElementById('Keterangan').value.trim();
            if (!keterangan) {
                errors.push('Keterangan tidak boleh kosong.');
            }

            // Validate Fasilitas Kamar
            const fasilitasKamar = Array.from(document.querySelectorAll('.fasilitas-kamar:checked')).map(checkbox => checkbox.value).join(', ');
            if (!fasilitasKamar) {
                errors.push('Pilih minimal satu Fasilitas Kamar.');
            } else {
                document.getElementById('Fasilitas_Kamar').value = fasilitasKamar;
            }

            // Validate Fasilitas Lainnya
            const fasilitasLainnya = Array.from(document.querySelectorAll('.fasilitas-lainnya:checked')).map(checkbox => checkbox.value).join(', ');
            if (!fasilitasLainnya) {
                errors.push('Pilih minimal satu Fasilitas Lainnya.');
            } else {
                document.getElementById('Fasilitas_Lainnya').value = fasilitasLainnya;
            }

            // Validate Harga
            const harga = document.getElementById('Harga').value.trim();
            if (!harga) {
                errors.push('Harga tidak boleh kosong.');
            }

            // Validate Images
            const img_1 = document.getElementById('img_1').files[0];
            const img_2 = document.getElementById('img_2').files[0];
            const img_3 = document.getElementById('img_3').files[0];
            const maxSize = 2048 * 1024; // 2MB

            if (img_1 && img_1.size > maxSize) {
                errors.push('Ukuran Gambar 1 terlalu besar. Maksimal 2MB.');
            }
            if (img_2 && img_2.size > maxSize) {
                errors.push('Ukuran Gambar 2 terlalu besar. Maksimal 2MB.');
            }
            if (img_3 && img_3.size > maxSize) {
                errors.push('Ukuran Gambar 3 terlalu besar. Maksimal 2MB.');
            }

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errors.join('<br>'),
                    confirmButtonText: 'OK'
                });
            } else {
                form.submit();
            }
        });
    });

    function previewImage(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ""; // Clear any previous previews
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('img_1').addEventListener('change', function() {
        previewImage(this, 'preview_1');
    });

    document.getElementById('img_2').addEventListener('change', function() {
        previewImage(this, 'preview_2');
    });

    document.getElementById('img_3').addEventListener('change', function() {
        previewImage(this, 'preview_3');
    });

    function collectCheckboxValues(className, hiddenInputId) {
        const checkboxes = document.querySelectorAll('.' + className);
        const values = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
        document.getElementById(hiddenInputId).value = values.join(', ');
    }

    document.getElementById('kamar-form').addEventListener('submit', function(event) {
        collectCheckboxValues('fasilitas-kamar', 'Fasilitas_Kamar');
        collectCheckboxValues('fasilitas-lainnya', 'Fasilitas_Lainnya');
    });
</script>
@endsection