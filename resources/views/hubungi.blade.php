@extends('layouts.master')

@section('title', 'hubungi')

@section('content')
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="breadcrumb"><a href="/">Beranda</a>  /  Hubungi Kami</span>
                <h3>Hubungi Kami</h3>
            </div>
        </div>
    </div>
</div>

<div class="contact-page section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>| tentang kami</h6>
                    <h2>Apa Itu KEKOST?</h2>
                </div>
                <p>KEKOST adalah platform yang menyediakan layanan penyewaan kamar kost secara online. Dengan KEKOST, Anda dapat dengan mudah mencari, membandingkan, dan memesan kamar kost yang sesuai dengan kebutuhan Anda. Kami menyediakan informasi lengkap mengenai fasilitas, harga, dan lokasi kost sehingga Anda dapat membuat keputusan yang tepat. Terima kasih telah mengunjungi KEKOST. Jika Anda membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami.</p>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="item phone">
                            <img src="assets/images/phone-icon.png" alt="" style="max-width: 52px;">
                            <h6>+62895363940340<br><span>Nomor Telpon</span></h6>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="item email">
                            <img src="assets/images/email-icon.png" alt="" style="max-width: 52px;">
                            <h6>kekost.app@gmail.com<br><span>Email</span></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form id="contact-form" action="{{ route('contact.send') }}" method="post" onsubmit="return validateForm();">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset>
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" id="name" placeholder="Nama..." autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <label for="email">Alamat Email</label>
                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-mail..." required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" id="subject" placeholder="Subject..." autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <label for="message">Pesan</label>
                                <textarea name="message" id="message" placeholder="Tuliskan Pesan" required></textarea>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" id="form-submit" class="orange-button">Kirim Pesan</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div id="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13198.196143845049!2d110.4090461!3d-7.7599049!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversity%20of%20Amikom%20Yogyakarta!5e1!3m2!1sen!2sid!4v1716464873133!5m2!1sen!2sid" width="100%" height="500px" frameborder="0" style="border:0; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function validateForm() {
    // Mendapatkan semua elemen input dalam formulir
    var inputs = document.querySelectorAll('#contact-form input[required], #contact-form textarea[required]');
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
</script>
@endsection
