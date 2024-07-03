@extends('layouts.master')

@section('title', 'Data Penyewa')

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


    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin-top: 40px !important;
        margin: auto;
        display: block;
        max-width: 50%;
        max-height: 50%;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 100%;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 0px;
        /* Adjust as necessary */
        right: 0px;
        /* Adjust as necessary */
        width: 40px;
        /* Ensure it's square */
        height: 40px;
        /* Ensure it's square */
        background-color: #495057;
        color: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        /* Adjust as necessary */
        font-weight: bold;
        border-radius: 10%;
        /* Make it a circle */
        transition: 0.3s;
        z-index: 9999;

    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 800px) {
        .modal-content {
            width: 100%;
            height: auto;
        }
    }

    .visitor-count-container {
        margin-top: 50px;
        /* Sesuaikan jarak sesuai kebutuhan */
        text-align: left;
        /* Pusatkan konten dalam visitor count container */
    }

    .visitor-count-container h3 {
        margin-bottom: 20px;
        /* Sesuaikan jarak antara judul dan grafik */
    }

    #timeFrameSelector {
        margin-bottom: 20px;
        /* Sesuaikan jarak antara dropdown dan grafik */
        padding: 5px;
        font-size: 16px;
    }

    /* Custom select styles */
    .custom-select {
        display: inline-block;
        width: 20%;
        font-size: 1rem;
        border-radius: 10px;
        position: relative;
    }

    .custom-select::after {
        content: "\25BC";
        position: absolute;
        top: 50%;
        right: 0.75rem;
        margin-top: -0.375rem;
        pointer-events: none;
        color: #495057;
    }

    #chartTypeSelector {
        color: #495057;
        width: 10% !important;
        border: none !important;
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
        <div class="header">
            <h3>Data Penyewa</h3>
        </div>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Penyewa</th>
                        <th>Nama Penyewa</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>ID Kamar</th>
                        <th>Durasi Sewa</th>
                        <th>Tgl Mulai Sewa</th>
                        <th>Tgl Habis Sewa</th>
                        <th>KTP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyewas as $pms)
                    <tr>
                        <td>{{ $pms->penyewa->ID_Penyewa }}</td>
                        <td>{{ $pms->penyewa->Username }}</td>
                        <td>{{ $pms->penyewa->Email }}</td>
                        <td>{{ $pms->penyewa->NoHP }}</td>
                        <td>{{ $pms->ID_Kamar }}</td>
                        <td>{{ $pms->Durasi_sewa }} Bulan</td>
                        <td>{{ $pms->Tgl_mulai_sewa }}</td>
                        <td>{{ $pms->Tgl_habis_sewa }}</td>
                        <td>
                            @if ($pms->penyewa->img_KTP)
                            <img id="myImg{{ $pms->ID }}" src="{{ asset('storage/' . $pms->penyewa->img_KTP) }}" alt="KTP" style="max-width: 100px;" onclick="openModal('myModal{{ $pms->ID }}', '{{ asset('storage/' . $pms->penyewa->img_KTP) }}')">
                            @else
                            Tidak ada gambar
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="visitor-count-container">
            <h3>Jumlah Pengunjung</h3>
            <select id="timeFrameSelector" class="custom-select">
                <option value="daily"> Harian</option>
                <option value="monthly"> Bulanan</option>
            </select>
            <br>

            <select id="chartTypeSelector">
                <option value="bar"><i class="fas fa-chart-bar"></i> Bar</option>
                <option value="line"><i class="fas fa-chart-line"></i> Line</option>
            </select>


            <canvas id="visitorChart"></canvas>

        </div>
    </div>
</div>


<!-- Modal for Images -->
@foreach ($penyewas as $pms)
<div id="myModal{{ $pms->ID }}" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('myModal{{ $pms->ID }}')">&times;</span>
        <img id="img{{ $pms->ID }}" style="width:100%">
        <div id="caption"></div>
    </div>
</div>
@endforeach


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

    document.addEventListener('DOMContentLoaded', function() {
        var dailyData = @json($dailyVisitors);
        var monthlyData = @json($monthlyVisitors);

        var ctx = document.getElementById('visitorChart').getContext('2d');
        var chartType = 'bar'; // Default chart type

        var chart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: dailyData.map(item => item.date),
                datasets: [{
                    label: 'Jumlah Pengunjung Harian',
                    data: dailyData.map(item => item.count),
                    backgroundColor: 'rgba(243, 85, 37, 0.2)', // Warna oranye dengan transparansi
                    borderColor: 'rgba(243, 85, 37, 1)', // Warna oranye solid
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Update chart data periodically bagian baru
        setInterval(() => {
            fetch('/path-to-get-latest-daily-visitors')
                .then(response => response.json())
                .then(newData => {
                    updateChart(chart, newData.map(item => item.date), newData.map(item => item.count), 'Jumlah Pengunjung Harian');
                });
        }, 60000); // Update every 60 seconds




        document.getElementById('timeFrameSelector').addEventListener('change', function() {
            var selectedOption = this.value;
            if (selectedOption === 'daily') {
                updateChart(chart, dailyData.map(item => item.date), dailyData.map(item => item.count), 'Jumlah Pengunjung Harian');
            } else if (selectedOption === 'monthly') {
                updateChart(chart, monthlyData.map(item => item.month), monthlyData.map(item => item.count), 'Jumlah Pengunjung Bulanan');
            }
        });

        document.getElementById('chartTypeSelector').addEventListener('change', function() {
            chartType = this.value;
            updateChartType(chart, chartType);
        });

        function updateChart(chart, labels, data, label) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.data.datasets[0].label = label;
            chart.update();
        }

        function updateChartType(chart, type) {
            chart.config.type = type;
            chart.update();
        }
    });
</script>

@endsection