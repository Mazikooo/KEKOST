@extends('layouts.master')

@section('title', 'carikamar')

@section('content')
<style>
    .item {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }

    .item:hover {
        transform: translateY(-10px);
    }

    .item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .search-bar {
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        display: flex;
        justify-content: center;
    }

    .search-bar input {
        width: 50%;
        padding: 10px 40px 10px 40px;
        font-size: 16px;
        border: 2px solid #A6A6A6;
        border-radius: 25px;
        outline: none;
        box-sizing: border-box;
    }

    .search-bar i {
        position: absolute;
        right: calc(70% + 10px);
        top: 50%;
        margin-right: 10px;
        transform: translateY(-50%);
        color: #f35525;
        pointer-events: none;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="breadcrumb"><a href="/">Beranda</a> / Cari Kamar</span>
                <h3>Cari Kamar</h3>
            </div>
        </div>
    </div>
</div>

<div class="section properties">
    <div class="container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan kota, nama kost, atau harga...">
            <i class="fas fa-search"></i>
        </div>

        <div class="row properties-box" id="propertiesBox">
            @foreach($kamars as $kamar)
            <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items">
                <div class="item">
                    <a href="{{ route('detailkamar', ['id' => $kamar->ID_Kamar]) }}">
                        <img src="{{ asset('storage/' . $kamar->img_1) }}" alt="" class="img-fluid">
                    </a>
                    <span class="category">{{ $kamar->pemilik->Nama_Kost }}</span>
                    <h6>{{ 'Rp ' . number_format($kamar->Harga, 0, ',', '.') }}<span style="font-size: 0.8em;">/bulan</span></h6>
                    <h4><a href="{{ route('detailkamar', ['id' => $kamar->ID_Kamar]) }}">{{ $kamar->pemilik->Kota }}</a></h4>
                    <div class="main-button">
                        <a href="{{ route('detailkamar', ['id' => $kamar->ID_Kamar]) }}">Booking Sekarang</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
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

        const propertiesBox = $('#propertiesBox');

        $('#searchInput').on('keyup', function() {
            const keyword = $(this).val();
            $.ajax({
                url: "{{ route('search') }}",
                method: 'GET',
                data: {
                    keyword: keyword
                },
                success: function(response) {
                    propertiesBox.html(response);
                    propertiesBox.addClass('search-result');
                }
            });
        });
    });
</script>
@endsection