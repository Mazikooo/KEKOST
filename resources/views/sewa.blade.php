@extends('layouts.master')

@section('title', 'Form Sewa')

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
        margin-bottom: 150px;
    }

    footer {
        padding: 10px 0;
        position: relative;
        bottom: 0;
        margin-top: auto;
        width: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
</style>
<div class="single-property section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h5 style="margin-bottom: 20px; color: #f35525;"> | BOOKING SEKARANG </h5>
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
            <div class="col-lg-5">
                <div class="form-sewa" style="width: 100%; max-width: 500px; margin: 0 auto; margin-bottom: 100px;">
                    <h5 style="margin-bottom: 0px; color: black;"> | FORM BOOKING </h5>
                    <p>*Isi data pada form dibawah untuk melakukan Booking</p>
                    <form id="payment-form">
                        @csrf
                        <input type="hidden" id="id_penyewa" name="id_penyewa" value="{{ $penyewa->ID_Penyewa }}">
                        <input type="hidden" id="tgl_pemesanan" name="tgl_pemesanan" value="{{ date('Y-m-d') }}">
                        <div class="mb-3">
                            <label for="durasi_sewa" class="form-label">Durasi Sewa (Bulan)</label>
                            <input type="number" class="form-control" id="durasi_sewa" name="durasi_sewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai_sewa" class="form-label">Tanggal Mulai Sewa</label>
                            <input type="date" class="form-control" id="tgl_mulai_sewa" name="tgl_mulai_sewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_habis_sewa" class="form-label">Tanggal Habis Sewa</label>
                            <input type="date" class="form-control" id="tgl_habis_sewa" name="tgl_habis_sewa" required readonly>
                        </div>
                        <input type="hidden" id="Nama_Lengkap" name="Nama_Lengkap" value="{{ $penyewa->Nama_Lengkap }}">
                        <input type="hidden" id="Email" name="Email" value="{{ $penyewa->Email }}">
                        <input type="hidden" id="NoHP" name="NoHP" value="{{ $penyewa->NoHP }}">
                        <div class="mb-3">
                            <label for="id_kamar" class="form-label">ID Kamar</label>
                            <input type="text" class="form-control" id="id_kamar" name="id_kamar" value="{{ $kamar->ID_Kamar }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tgl_pemesanan').value = today;

        const durasiSewaElement = document.getElementById('durasi_sewa');
        const tglMulaiSewaElement = document.getElementById('tgl_mulai_sewa');
        const tglHabisSewaElement = document.getElementById('tgl_habis_sewa');
        const totalHargaElement = document.getElementById('total_harga');

        function calculateEndDate() {
            const startDate = new Date(tglMulaiSewaElement.value);
            const duration = parseInt(durasiSewaElement.value, 10);

            if (!isNaN(startDate.getTime()) && !isNaN(duration)) {
                startDate.setMonth(startDate.getMonth() + duration);
                tglHabisSewaElement.value = startDate.toISOString().split('T')[0];

                const hargaKamar = {{ $kamar->Harga }};
                const totalHarga = hargaKamar * duration;
                totalHargaElement.value = 'Rp ' + totalHarga.toLocaleString('id-ID');
            }
        }

        durasiSewaElement.addEventListener('change', calculateEndDate);
        tglMulaiSewaElement.addEventListener('input', calculateEndDate);

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            fetch('{{ route('payment.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_penyewa: document.getElementById('id_penyewa').value,
                            tgl_pemesanan: document.getElementById('tgl_pemesanan').value,
                            durasi_sewa: document.getElementById('durasi_sewa').value,
                            tgl_mulai_sewa: document.getElementById('tgl_mulai_sewa').value,
                            tgl_habis_sewa: document.getElementById('tgl_habis_sewa').value,
                            Nama_Lengkap: document.getElementById('Nama_Lengkap').value,
                            id_kamar: document.getElementById('id_kamar').value,
                            total_harga: document.getElementById('total_harga').value,
                            Email: document.getElementById('Email').value,
                            NoHP: document.getElementById('NoHP').value,
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log(result);
                            // Implement success action, e.g. redirect or show success message
                        },
                        onPending: function(result) {
                            console.log(result);
                            // Implement pending action, e.g. show pending message
                        },
                        onError: function(result) {
                            console.log(result);
                            // Implement error action, e.g. show error message
                        },
                        onClose: function() {
                            console.log('customer closed the popup without finishing the payment');
                            // Implement action when customer closes the popup
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function validateForm() {
        var inputs = document.querySelectorAll('#register-form input[required]');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value.trim() === '') {
                var label = document.querySelector('label[for="' + inputs[i].id + '"]').innerText;
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: label + ' harus diisi',
                    confirmButtonText: 'OK'
                });
                return false;
            }
        }
        return true;
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