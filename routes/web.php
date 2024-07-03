<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HubungiController;
use App\Http\Controllers\CariKamarController;
use App\Http\Controllers\RegisterPemilikController;
use App\Http\Controllers\LoginPemilikController;
use App\Http\Controllers\ProfilePemilikController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Mail\BookingConfirmation;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BotManController;

Route::get('/', [HomeController::class, 'index']);



Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/chatbot', function () {
    return view('chatbot');
});

Route::get('/carikamar', [CariKamarController::class, 'index'])->name('carikamar');
Route::get('/search', [CariKamarController::class, 'search'])->name('search');
Route::get('/detailkamar/{id}', [HomeController::class, 'detailKamar'])->name('detailkamar');
Route::get('/sewa/{id}', [CariKamarController::class, 'Sewa'])->name('sewa');
Route::post('/storeSewa', [CariKamarController::class, 'storeSewa'])->name('storeSewa');
Route::get('/hubungi', [HubungiController::class, 'index'])->name('hubungi');


// Route::middleware(['auth:penyewa'])->group(function () {
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });

Route::middleware('auth:pemilik,penyewa')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth:penyewa')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::post('profile/{ID_Penyewa}/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/menubooking', [ProfileController::class, 'showBooking'])->name('menu.booking');
    Route::post('/menubooking/testimoni', [ProfileController::class, 'testimoni'])->name('testimoni.store');
    Route::delete('/testimoni/{id}', [ProfileController::class, 'testimonidlt'])->name('testimoni.delete');
    Route::get('/menubooking/print/{orderId}', [ProfileController::class, 'print'])->name('pemesanan.print');
    Route::get('/profile/ganti-sandi', [ProfileController::class, 'gantiSandi'])->name('profile.gantiSandi');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});

Route::middleware('auth:pemilik')->group(function () {
    Route::get('/profile-pemilik', [ProfilePemilikController::class, 'showProfile'])->name('profile.pemilik');
    Route::post('profile-pemilik/{ID_Pemilik}/update', [ProfilePemilikController::class, 'updateProfile'])->name('profile.update.pemilik');

    Route::get('/profile-pemilik/ganti-sandi', [ProfilePemilikController::class, 'gantiSandi'])->name('profile.gantiSandi.pemilik');
    Route::post('/profile-pemilik/change-password', [ProfilePemilikController::class, 'changePassword'])->name('profile.changePassword.pemilik');
    Route::get('/profile-pemilik/dataPenyewa', [ProfilePemilikController::class, 'indexPenyewa'])->name('data.penyewa');

    Route::get('/profile-pemilik/dataTransaksi', [ProfilePemilikController::class, 'indexTransaksi'])->name('data.transaksi');
    Route::get('/dataTransaksi/print/{orderId}', [ProfilePemilikController::class, 'print'])->name('transaksi.print');
    Route::get('/dataTransaksi/cetak-laporan', [ProfilePemilikController::class, 'cetakLaporan'])->name('transaksi.cetak-laporan');

    
    Route::put('/update-status/{id}', [ProfilePemilikController::class, 'updateStatus'])->name('update.status');
    Route::get('kamar', [ProfilePemilikController::class, 'indexKamar'])->name('kamar.pemilik');
    Route::get('kamar/create', [ProfilePemilikController::class, 'createKamar'])->name('kamar.create');
    Route::post('kamar', [ProfilePemilikController::class, 'storeKamar'])->name('kamar.store');
    Route::get('kamar/{id}/edit', [ProfilePemilikController::class, 'editKamar'])->name('kamar.edit');
    Route::put('kamar/{id}', [ProfilePemilikController::class, 'updateKamar'])->name('kamar.update');
    Route::delete('kamar/{id}', [ProfilePemilikController::class, 'destroyKamar'])->name('kamar.destroy');
});

Route::get('/login-pemilik', [LoginPemilikController::class, 'showLoginForm'])->name('login.pemilik');
Route::post('/login-pemilik', [LoginPemilikController::class, 'login'])->name('login.submit.pemilik');
Route::post('/logout-pemilik', [LoginPemilikController::class, 'logout'])->name('logout.pemilik');



Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.webhook');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');



Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/register-pemilik', [RegisterPemilikController::class, 'showRegistrationForm'])->name('register.pemilik');
Route::post('/register-pemilik', [RegisterPemilikController::class, 'register'])->name('register.submit.pemilik');



Route::get('/test-email', function () {
    $pemesanan = [
        'Nama_Lengkap' => 'Test User',
        'Email' => 'mabonesnft@gmail.com',  // Pastikan ini adalah email yang valid untuk pengujian
        'NoHP' => '1234567890',
        'Durasi_sewa' => '1 bulan',
        'Tgl_mulai_sewa' => '2023-06-01',
        'Tgl_habis_sewa' => '2023-07-01',
        'Total_harga' => 999999986,
        'Order_Id' => uniqid(),
    ];

    Mail::to('mabonesnft@gmail.com')->send(new BookingConfirmation((object) $pemesanan));
    return 'Email sent!';
});


Route::get('/test-email-regis', function () {
    $penyewa = [
        'Nama_Lengkap' => 'Test User',
        'Email' => 'mabonesnft@gmail.com',  
    ];

    Mail::to($penyewa['Email'])->send(new WelcomeEmail((object) $penyewa));

    return 'Email selamat datang telah dikirim!';
});



Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
