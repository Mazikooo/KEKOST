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
    }

    .main-content {
        flex: 1 !important;
    }

    .table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        color: #333;
        border-radius: 8px 8px 0 0;
        overflow: hidden;
        margin: 20px 0;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 20px;

    }

    .table th,
    .table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 10px;
        border: 0px solid #ddd;

    }

    .table th {
        background-color: #EBEAEA;
        font-weight: bold;

        text-align: left;
        width: 150px;
    }

    .table td {
        max-width: 150px;
        text-align: left;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 300px !important;
        /* Sesuaikan lebar sesuai kebutuhan */
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

    .btn-edit {
        background-color: #4CAF50 !important;
    }

    .btn-edit:hover {
        background-color: #45a049 !important;
        color: white;
    }

    .btn-hapus {
        background-color: #f44336 !important;
    }

    .btn-hapus:hover {
        background-color: #da190b !important;
        color: white;
    }

    .status-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .modern-select {
        appearance: none;
        /* Remove default arrow */
        -webkit-appearance: none;
        /* Remove default arrow in Safari */
        -moz-appearance: none;
        /* Remove default arrow in Firefox */
        width: 100%;
        padding: 8px 40px 12px 13px;
        /* Adjust padding for better appearance */
        border: 1px solid #ccc;
        /* Border color */
        border-radius: 4px;
        /* Rounded corners */
        background-color: #f8f8f8;
        /* Background color */
        font-size: 16px;
        /* Font size */
        color: #333;
        /* Font color */
        line-height: 1;
        /* Ensure text is not cut off */
    }

    .status-dropdown .arrow-down {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        /* Allow clicks to pass through */
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #333;
        /* Arrow color */
    }

    .status-dropdown:hover .modern-select {
        border-color: #888;
        /* Change border color on hover */
    }

    .status-dropdown:focus-within .modern-select {
        border-color: #555;
        /* Change border color on focus */
        outline: none;
    }
</style>

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
            <h3>Data Kamar</h3>
            <a href="{{ route('kamar.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>
        </div>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kamar</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Fasilitas Kamar</th>
                        <th>Fasilitas Lainnya</th>
                        <th>Status Layanan</th>
                        <th>Gambar 1</th>
                        <th>Gambar 2</th>
                        <th>Gambar 3</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kamar as $kmr)
                    <tr>
                        <td>{{ $kmr->ID_Kamar }}</td>
                        <td>{{ $kmr->Keterangan }}</td>
                        <td>{{ 'Rp ' . number_format($kmr->Harga, 0, ',', '.') }}</td>
                        <td>{{ $kmr->Fasilitas_Kamar }}</td>
                        <td>{{ $kmr->Fasilitas_Lainnya }}</td>
                        <td class="status-cell">
                            <div class="status-dropdown">
                                <select class="form-control status-select modern-select" data-id="{{ $kmr->ID_Kamar }}">
                                    <option value="Tersedia" {{ $kmr->Status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Dipesan" {{ $kmr->Status == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                                </select>
                                <div class="arrow-down"></div>
                            </div>
                        </td>
                        <td><img src="{{ asset('storage/' . $kmr->img_1) }}" alt="Gambar 1" style="max-width: 100px;"></td>
                        <td><img src="{{ asset('storage/' . $kmr->img_2) }}" alt="Gambar 2" style="max-width: 100px;"></td>
                        <td><img src="{{ asset('storage/' . $kmr->img_3) }}" alt="Gambar 3" style="max-width: 100px;"></td>
                        <td style="display: flex; gap: 10px; border: none;">
                            <a href="{{ route('kamar.edit', $kmr->ID_Kamar) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('kamar.destroy', $kmr->ID_Kamar) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
    });
    // Menangani perubahan dropdown status
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('status-select')) {
            const idKamar = e.target.getAttribute('data-id');
            const newStatus = e.target.value;

            // Kirim request ke backend untuk update status kamar
            fetch(`/update-status/${idKamar}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Status berhasil diubah.',
                        confirmButtonText: 'OK'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengubah status.',
                        confirmButtonText: 'OK'
                    });
                });
        }
    });
</script>
@endsection