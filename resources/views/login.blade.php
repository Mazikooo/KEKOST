<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form>
                <h1>Buat Akun</h1>

                <span>Lengkapi Data Dibawah untuk Registrasi</span>
                <input type="text" placeholder="Name">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form>
                <h1>Sign In</h1>

                <span>Masukan Username dan Password Untuk Login</span>
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">

                <button>Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Selamat Datang!</h1>
                    <p>Masuk ke Akun dan Mulai Mencari Kost Impian.</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Selamat Datang!</h1>
                    <p>Belum Memiliki Akun? Klik Sign Up Untuk Registrasi</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/script-login.js') }}"></script>
</body>

</html>