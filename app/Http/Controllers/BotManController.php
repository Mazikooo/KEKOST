<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Http\Request;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [];
        $botman = BotManFactory::create($config);

        // Define your botman hears() patterns and actions
        $botman->hears('.*start.*|hai|halo|siapa kamu', function (BotMan $bot) {
            $bot->reply('Halo! Saya asisten virtual KEKOST. Ketik pertanyaan Anda di sini, misalnya <br>
            "Apa itu KEKOST?", <br>
            "Bagaimana cara booking?", atau <br>
            "Apa metode pembayarannya?"');
        });

        $botman->hears('.*apa itu kekost|kekost|apa ini|website apa.*', function (BotMan $bot) {
            $bot->reply('KEKOST adalah platform penyewaan kamar kost yang memudahkan pencari kost untuk menemukan dan memesan kamar secara online. Kami menawarkan berbagai pilihan kost dengan fasilitas terbaik.');
        });

        $botman->hears('.*bagaimana cara booking|cara booking|booking|pemesanan|cara pesan.*', function (BotMan $bot) {
            $bot->reply('Anda dapat melakukan booking kamar kost di KEKOST dengan melakukan langkah-langkah berikut:<br>
        1. Cari kamar kost yang Anda inginkan.<br>
        2. Klik tombol "Booking Sekarang" pada kamar yang dipilih.<br>
        3. Isi informasi yang diperlukan dan konfirmasi pemesanan.<br>
        4. Lakukan pembayaran sesuai dengan metode yang tersedia.<br>
        5. Setelah pembayaran terkonfirmasi, Anda akan menerima detail booking melalui email.');
        });

        $botman->hears('.*apa metode pembayarannya|bayar|cara bayar|pembayaran.*', function (BotMan $bot) {
            $bot->reply('Metode pembayaran di KEKOST dapat dilakukan secara online melalui berbagai metode seperti:<br>
        1. Transfer bank.<br>
        2. Pembayaran kartu kredit.<br>
        3. Dompet digital seperti OVO, GoPay, dan DANA.');
        });

        $botman->hears('.*bantuan|help|butuh bantuan|tolong|eror|error|tidak bisa.*', function (BotMan $bot) {
            $bot->reply('Jika Anda mengalami masalah, Anda dapat menghubungi layanan pelanggan kami melalui:<br>
        1. Isi form pada menu "hubungi kami" di website kami.<br>
        2. Email ke kekost.app@gmail.com.<br>
        3. Kirim pesan ke +62895363940340.');
        });

        $botman->hears('.*syarat dan ketentuan.*|terms|syarat|ketentuan', function (BotMan $bot) {
            $bot->reply('Informasi mengenai syarat dan ketentuan dapat Anda temukan di halaman "Syarat dan Ketentuan" di website kami. Anda juga dapat menghubungi layanan pelanggan untuk informasi lebih lanjut.');
        });

        $botman->hears('.*kebijakan privasi.*|privasi|kebijakan', function (BotMan $bot) {
            $bot->reply('KEKOST sangat menjaga privasi pengguna. Informasi lebih lanjut mengenai kebijakan privasi kami dapat Anda baca di halaman "Kebijakan Privasi" di website kami.');
        });


        // Fallback for unrecognized questions
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Maaf, saya tidak mengerti pertanyaan Anda. Silakan coba lagi dengan pertanyaan yang lain.');
        });

        // Start listening
        $botman->listen();
    }
}
