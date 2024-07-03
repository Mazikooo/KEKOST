@extends('layouts.master')

@section('title', 'detailKamar')

@section('content')

<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
    }

    footer {
        padding: 10px 0;
        position: relative;
        bottom: 0;
        width: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        margin: 0;
        padding: 0;
    }

    .fasilitas-list {
        padding: 0;
    }

    .fasilitas-list li {
        margin: 0;
    }

    .fasilitas-list i {
        margin-right: 3px;
        color: ORANGE;
    }
    .testimonial-item {
        position: relative;
    }

    .delete-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: transparent;
        border: none;
        color: grey;
        cursor: pointer;
    }

    .delete-btn:hover {
        color: #e50000;
        background-color: transparent;
    }

    .delete-btn i {
        font-size: 1.0em;
    }

</style>
<div class="single-property section">
    <div class="container">
        <div class="row">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <div class="col-lg-8">
                <h5 style="margin-bottom: 20px; color: #f35525;"> | DETAIL KAMAR </h5>
                <!-- Carousel -->
                <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $kamar->img_1) }}" class="d-block w-100" alt="...">
                        </div>
                        @if($kamar->img_2)
                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $kamar->img_2) }}" class="d-block w-100" alt="...">
                        </div>
                        @endif
                        @if($kamar->img_3)
                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $kamar->img_3) }}" class="d-block w-100" alt="...">
                        </div>
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- End of Carousel -->
                <div class="main-content">
                    <span class="nama">{{ $kamar->pemilik->Nama_Kost }}</span>
                    <h3>{{ 'Rp ' . number_format($kamar->Harga, 0, ',', '.') }} <span style="font-size: smaller; font-weight: 400;">/ Bulan</span></h3>
                    <h4>{{ $kamar->pemilik->Alamat }} <span style="font-size: 15px; font-weight: 400;"> {{ $kamar->pemilik->Kota }} , {{ $kamar->pemilik->Provinsi }}</span></h4>
                    <p>{!! nl2br(e($kamar->Keterangan)) !!}</p>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="info-table">
                    <ul>
                        <!-- Fasilitas Kamar -->
                        <li>
                            <h4>Fasilitas Kamar</h4>
                            <ul class="fasilitas-list">
                                @foreach(explode(', ', $kamar->Fasilitas_Kamar) as $fasilitas)
                                <i class="fas fa-check"></i> {{ $fasilitas }}<br>
                                @endforeach
                            </ul>
                        </li>

                        <!-- Fasilitas Lainnya -->
                        <li>
                            <h4>Fasilitas Lainnya</h4>
                            <ul class="fasilitas-list">
                                @foreach(explode(', ', $kamar->Fasilitas_Lainnya) as $fasilitas)
                                <i class="fas fa-check"></i> {{ $fasilitas }}<br>
                                @endforeach
                            </ul>
                        </li>

                        <div class="icon-button">
                            @if(Auth::guard('penyewa')->check())
                            <a href="{{ route('sewa', $kamar->ID_Kamar) }}"><i class="fa fa-calendar-check"></i> Booking Sekarang</a>
                            @elseif(Auth::guard('pemilik')->check())
                            <!-- Pemilik login, tombol tidak ditampilkan -->
                            @else
                            <a href="#" onclick="showLoginAlert()"><i class="fa fa-calendar-check"></i> Booking Sekarang</a>
                            @endif
                        </div>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Testimoni Section -->
<div class="section testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-headingdetail">
                    <h6>| Ulasan</h6>
                </div>
            </div>
            <div class="col-lg-12">
                @forelse ($testimonis as $testimoni)
                <div class="testimonial-item" style="position: relative; background-color: white; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                    <h4>{{ $testimoni->Username }}</h4>
                    <div class="stars">
                        @for ($i = 0; $i < 5; $i++)
                        <i class="fa fa-star" style="color: {{ $i < $testimoni->Rating ? '#f35525' : 'gray' }};"></i>
                        @endfor
                    </div>
                    <p>{{ $testimoni->Pesan }}</p>
                    @if(auth()->guard('penyewa')->check() && $testimoni->ID_Penyewa == auth()->guard('penyewa')->user()->ID_Penyewa)
                    <button onclick="confirmDeletion('{{ route('testimoni.delete', $testimoni->ID_Testimoni) }}')" class="btn btn-danger delete-btn">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endif
                </div>
                @empty
                <div class="testimonial-item" style="padding: 20px; margin-bottom: 20px;">
                    <p>Belum ada ulasan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showLoginAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Harus Masuk ke Akun',
            text: 'Anda harus masuk ke akun untuk melakukan booking!',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Login'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('login') }}';
            }
        });
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


    function confirmDeletion(url) {
        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus ulasan ini?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat dan kirim form secara dinamis
                var form = document.createElement('form');
                form.action = url;
                form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection