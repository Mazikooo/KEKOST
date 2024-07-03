@extends('layouts.master')

@section('title', 'Data Transaksi')

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
    }

    .main-content {
        flex: 1 !important;
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


</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-lmNvb3JFV0KS1uK67pGFLpNzTAR4Woyks6E3Z/dRD+tr+OJL0kkfNHPrqj3PbgJf" crossorigin="anonymous">
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="profile-header">
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
            <div class="header row">
                <div class="col">
                    <h3>Data Transaksi</h3>
                </div>
                <div class="col-auto">
                    <a href="{{ route('transaksi.cetak-laporan') }}" class="btn btn-primary mb-3" style="max-width: 150px;" target="_blank" onclick="event.stopPropagation();">Cetak Laporan</a>
                </div>
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
                    @foreach ($pemesanans as $pms)
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
                            <a href="{{ route('transaksi.print', ['orderId' => $pms->Order_Id]) }}" class="btn btn-print" target="_blank" onclick="event.stopPropagation();">
                                <i class="fas fa-print"></i>
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
<form id="logout-form" action="{{ route('logout.pemilik') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tambahkan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan Magnific Popup -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    // Open the Modal
    function openModal(modalId, imgSrc) {
        var modal = document.getElementById(modalId);
        var modalImg = modal.querySelector("img");
        modalImg.src = imgSrc;
        modal.style.display = "block";
        document.body.style.overflow = "hidden"; // Disable scrolling
    }

    // Close the Modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
        document.body.style.overflow = ""; // Enable scrolling
    }




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