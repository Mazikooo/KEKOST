@extends('layouts.master')

@section('title', 'Profil Pemilik')

@section('content-profil')

<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        /* Ensure body takes at least the full viewport height */
    }

    .main-content {
        flex: 1 !important;
        /* Expand main-content to fill remaining vertical space */
    }

    .table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
        /* Menggabungkan border */
        font-family: Arial, sans-serif;
        color: #333;
        border-radius: 8px 8px 0 0;
        /* Membuat sudut atas melengkung */
        overflow: hidden;
        /* Mencegah overflow di sudut melengkung */
        margin: 20px 0;
        /* Menambahkan margin di atas dan bawah tabel */
    }

    .table-container {
        overflow-x: auto;
        /* Agar tabel dapat di-scroll jika sangat lebar */
        margin-top: 20px;

    }

    .table th,
    .table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 10px;
        /* Menambahkan padding untuk ruang lebih */
        border: 0px solid #ddd;
        /* Menambahkan border pada sel */
    }

    .table th {
        background-color: #f2673c;
        /* Warna latar belakang untuk header */
        font-weight: bold;
        color: white;
        text-align: left;
        /* Rata kiri untuk teks di header */
        width: 150px;
        /* Atur lebar kolom sesuai kebutuhan */
    }

    .table td {
        max-width: 150px;
        /* Atur lebar kolom sesuai kebutuhan */
        text-align: left;
        /* Rata kiri untuk teks di sel */
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
        /* Warna latar belakang untuk baris genap */
    }

    .table tr:hover {
        background-color: #f1f1f1;
        /* Warna latar belakang saat baris dihover */
    }


    footer {
        padding: 10px 0;
        position: relative !important;
        bottom: 0;
        width: 100%;
        margin-top: auto;
    }

    .profile-content {

        padding: 20px;
        margin-bottom: 200px;
        max-width: 100%;
    }

    .btn-print {
        background-color: #2A6BC0 !important;
    }

    .btn-print:hover {
        background-color: #135BB9 !important;
        color: white;
    }

    .btn-nilai {
        background-color: #f44336 !important;
        /* Red */
    }

    .btn-nilai:hover {
        background-color: #da190b !important;
        /* Darker Red */
        color: white;
    }
</style>

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
        <div class="header">
            <h3>Data Booking</h3>
        </div>
        <div class="table-container">
            @if(isset($pesan))
            <p>{{ $pesan }}</p>
            @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Durasi Sewa</th>
                        <th>Total Harga</th>
                        <th>Tgl Mulai Sewa</th>
                        <th>Tgl Habis Sewa</th>
                        <th>ID Kamar</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $pms)
                    <tr onclick="window.location='{{ route('detailkamar', ['id' => $pms->ID_Kamar]) }}'" style="cursor: pointer;">
                        <td>{{ $pms->Order_Id }}</td>
                        <td>{{ $pms->Durasi_sewa }} Bulan</td>
                        <td>{{ 'Rp ' . number_format($pms->Total_harga, 0, ',', '.') }}</td>
                        <td>{{ $pms->Tgl_mulai_sewa }}</td>
                        <td>{{ $pms->Tgl_habis_sewa }}</td>
                        <td>{{ $pms->ID_Kamar }}</td>
                        <td>{{ $pms->Email }}</td>
                        <td>{{ $pms->NoHP }}</td>
                        <td style="display: flex; gap: 10px; border: none;">
                            <a href="{{ route('pemesanan.print', ['orderId' => $pms->Order_Id]) }}" class="btn btn-print" target="_blank" onclick="event.stopPropagation();">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="#" class="btn btn-nilai" onclick="event.stopPropagation();">
                                <i class="fas fa-star"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

<!-- Formulir Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


<!-- Modal Form Testimoni -->
<div class="modal fade" id="testimoniModal" tabindex="-1" role="dialog" aria-labelledby="testimoniModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testimoniModalLabel">Isi Ulasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('testimoni.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_Kamar" id="ID_Kamar">
                    <input type="hidden" name="ID_Penyewa" id="ID_Penyewa">

                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" class="form-control" name="Username" id="Username" value="{{ Auth::guard('penyewa')->user()->Username }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="Rating">Rating</label>
                        <input type="number" class="form-control" name="Rating" id="Rating" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="Pesan">Pesan</label>
                        <textarea class="form-control" name="Pesan" id="Pesan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var testimoniButtons = document.querySelectorAll('.btn-nilai');
        testimoniButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var row = button.closest('tr');
                var idKamar = row.querySelector('td:nth-child(6)').innerText;
                var email = row.querySelector('td:nth-child(7)').innerText;

                document.getElementById('ID_Kamar').value = idKamar;
                document.getElementById('ID_Penyewa').value = email;
                $('#testimoniModal').modal('show');
            });
        });

        // Event listener untuk tombol 'x' pada modal testimoni
        var closeButton = document.querySelector('.modal .close');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                $('#testimoniModal').modal('hide');
            });
        }

        // Event listener untuk tombol 'Batal' pada modal testimoni
        var cancelButton = document.querySelector('.modal-footer .btn-secondary');
        if (cancelButton) {
            cancelButton.addEventListener('click', function() {
                $('#testimoniModal').modal('hide');
            });
        }
    });



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