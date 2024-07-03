<!-- resources/views/home.blade.php -->
@extends('layouts.master')

@section('title', 'Home')

@section('content')
<style>
  .main-banner .header-text {
    position: absolute;
    z-index: 2;
    left: 0;
    padding-left: 100px;
  }

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

  .detail-link {
    color: #f35525;
    /* Warna tautan awal */
    text-decoration: none;
    /* Menghilangkan garis bawah default */
  }

  .detail-link:hover {
    color: #c44d29;
    /* Warna tautan saat di-hover */
    text-decoration: underline;
    /* Menambahkan garis bawah saat di-hover */
  }
</style>
<div class="main-banner">
  <div class="item item-1">
    <div class="overlay"></div>
    <div class="header-text">
      <div class="header-button">
        <a href="{{ route('carikamar') }}">Mulai Cari</a>
      </div>
      <h2><span class="typed-text" id="typed-text"></span></h2>
    </div>
  </div>
</div>
</div>
</div>


<div class="featured section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="left-image">
          <img src="assets/images/regis3.png" alt="">
          <!-- <a href="property-details.html"><img src="assets/images/featured-icon.png" alt="" style="max-width: 60px; padding: 0px;"></a> -->
        </div>
      </div>
      <div class="col-lg-5">
        <div class="section-heading">
          <h6>| Mulai Daftarkan Kost</h6>
          <h2>Segera Daftarkan Kost Milikmu Disini!</h2>
        </div>
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Kenapa Harus Mendaftarkan Kost Anda Disini ?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Kami memiliki jaringan luas yang menjangkau ribuan pencari kost. Kostmu akan lebih mudah ditemukan oleh calon penyewa. Selain itu, proses pendaftaran mudah dan cepat, serta kamu dapat memonitor penyewaan kostmu.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Bagiamana Cara Mendaftar ?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>Berikut langkah-langkah pendaftaran:</strong>

                <ol>
                  <li><strong>1. </strong>Buat akun dengan mengisi formulir pendaftaran di halaman registrasi.</li>
                  <li><strong>2. </strong>Login ke akun kamu dan lengkapi profil kost dengan informasi yang lengkap dan menarik, termasuk foto-foto fasilitas yang tersedia.</li>
                  <li><strong>3. </strong>Setelah itu, kostmu akan tayang dan bisa dilihat oleh calon penyewa.</li>
                  <div class="registerkost-button">
                    <a href="{{ route('register.pemilik') }}">Mulai Registrasi</a>
                  </div>
                </ol>
                Jika mengalami kesulitan, jangan ragu untuk menghubungi layanan pelanggan kami.
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-3">
        <div class="info-table">
          <ul>
            <li>
              <img src="assets/images/info-icon-01.png" alt="" style="max-width: 52px;">
              <h4>Informasi<br><span>Mudah Diberi</span></h4>
            </li>
            <li>
              <img src="assets/images/info-icon-02.png" alt="" style="max-width: 52px;">
              <h4>Monitor<br><span>Penyewaan Anda</span></h4>
            </li>
            <li>
              <img src="assets/images/info-icon-03.png" alt="" style="max-width: 52px;">
              <h4>Transaksi<br><span>Lebih Mudah</span></h4>
            </li>
            <li>
              <img src="assets/images/info-icon-04.png" alt="" style="max-width: 52px;">
              <h4>Terjamin<br><span>Aman & Mudah</span></h4>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- <div class="section best-deal">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="section-heading">
          <h6>| REKOMENDASI</h6>
          <h2>Cari Kost Terbaik Ada Disini!</h2>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="tabs-content">
          <div class="row">


             <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="appartment" role="tabpanel" aria-labelledby="appartment-tab">
                @foreach($kamars as $kamar)
                @if($kamar->ID_Kamar == 13)
                <div class="row">
                  <div class="col-lg-3">
                    <div class="info-table">
                      <ul>
                        <li><h3>{{ $kamar->pemilik->Nama_Kost }}</h3></li>
                        <li>Harga Sewa <span>{{ 'Rp ' . number_format($kamar->Harga, 0, ',', '.') }}</span></li>
                        <li>Lokasi<span>{{ $kamar->pemilik->Alamat }}</span></li>
                        <li>Fasilitas<span>Lengkap</span></li>
                        <li>Pembayaran<span>Online</span></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <img src="{{ asset('storage/' . $kamar->img_1) }}" alt="" class="img-fluid">
                  </div>
                  <div class="col-lg-3">
                    <h4>Tentang Kost</h4>
                    <p>{{ Str::limit($kamar->Keterangan, 400, '...') }}</p>
                    <a href="{{ route('detailkamar', ['id' => 13]) }}" class="detail-link">Detail selengkapnya</a>

                  </div>
                </div>
                @endif
                @endforeach
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->




<div class="properties section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 offset-lg-4">
        <div class="section-heading text-center">
          <h6>| DAFTAR KOST</h6>
          <h2>Tentukan Kost Buatmu!</h2>
        </div>
      </div>
    </div>

    <div class="row">
      @foreach($kamars as $kamar)
      <div class="col-lg-4 col-md-6">
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

<div class="main-button2">
  <a href="{{ route('carikamar') }}"><strong>Tampilkan lebih banyak</strong></a>
</div>


<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script>
  var typed = new Typed('#typed-text', {
    strings: ['Mulai Cari<br><span id="orange">Kost </span>Impianmu<br>Disini!'],
    typeSpeed: 50,
  });
</script>





@endsection