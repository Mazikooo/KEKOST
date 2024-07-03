<style>
        .search-result {
        margin-top: -50px; 
    }
</style>
<div class="section properties">
    <div class="container">
        <div class="row properties-box search-result" id="propertiesBox">
        @if($kamars->isEmpty())
                <div class="col-12 text-center">
                    <p>Kost yang kamu cari tidak ada.</p>
                </div>
            @else
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
            @endif
        </div>
    </div>
</div>
