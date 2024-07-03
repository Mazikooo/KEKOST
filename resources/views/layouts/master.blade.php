<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>KEKOST</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/home-title.png') }}">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/maincss.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />


    <!-- CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript (optional, for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
    </style>
</head>

<body>


    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    @yield('content')

    <div class="container">
        @yield('content-profil')
    </div>
    <!-- Scripts -->
    @livewireScripts


    <!-- Footer -->
    @include('layouts.footer')


    <script>
        var botmanWidget = {
            frameEndpoint: '/botman/chat',
            introMessage: 'Selamat datang di KEKOST! Ada yang bisa saya bantu?',
            chatServer: '/botman',
            title: 'KEKOST',
            mainColor: '#f35525',
            bubbleBackground: '#f35525',
            bubbleAvatarUrl: '/assets/images/chat3.png', // URL avatar bubble
            desktopHeight: '400px', // Tinggi chatbot di desktop
            desktopWidth: '350px', // Lebar chatbot di desktop
            mobileHeight: '300px', // Tinggi chatbot di mobile
            mobileWidth: '300px', // Lebar chatbot di mobile
            placeholderText: 'Ketik pesan...', // Teks placeholder
            aboutText: '', // Teks "about"
            chatServer: '/botman', // URL server chat
        };
    </script>


    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</body>

</html>