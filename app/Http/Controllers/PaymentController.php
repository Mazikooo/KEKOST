<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Kamar;

use Midtrans\Snap;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
    }

    public function processPayment(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $orderId = uniqid();
        $grossAmount = (int) str_replace(['Rp ', '.'], '', $request->input('total_harga'));

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        $customer_details = [
            'first_name' => $request->input('Nama_Lengkap'),
            'email' => $request->input('Email'),
            'phone' => $request->input('NoHP'),
        ];

        $item_details = [
            [
                'id' => $request->input('id_kamar'),
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Sewa Kamar ' . $request->input('id_kamar')
            ]
        ];

        $custom_field1 = 'Durasi: ' . $request->input('durasi_sewa');
        $custom_field2 = 'Tgl Mulai: ' . $request->input('tgl_mulai_sewa');
        $custom_field3 = 'Tgl Habis: ' . $request->input('tgl_habis_sewa');

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'custom_field1' => $custom_field1,
            'custom_field2' => $custom_field2,
            'custom_field3' => $custom_field3,
            'callbacks' => [
                'finish' => route('payment.finish') // Menambahkan URL callback untuk redirect setelah transaksi selesai
            ]
        ];

        $pemesanan = Pemesanan::create([
            'Tgl_Pemesanan' => $request->input('tgl_pemesanan'),
            'Durasi_sewa' => $request->input('durasi_sewa'),
            'Tgl_mulai_sewa' => $request->input('tgl_mulai_sewa'),
            'Tgl_habis_sewa' => $request->input('tgl_habis_sewa'),
            'Total_harga' => $grossAmount,
            'ID_Penyewa' => $request->input('id_penyewa'),
            'ID_Kamar' => $request->input('id_kamar'),
            'Nama_Lengkap' => $request->input('Nama_Lengkap'),
            'Email' => $request->input('Email'),
            'NoHP' => $request->input('NoHP'),
            'Order_Id' => $orderId,
        ]);

        // Update the status of the room to "Dipesan"
        $kamar = Kamar::find($request->input('id_kamar'));
        if ($kamar) {
            $kamar->Status = 'Dipesan';
            $kamar->save();
        }


        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Gagal memproses pembayaran: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }


    public function handleWebhook(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $pemesanan = Pemesanan::where('Order_Id', $request->order_id)->first();

            if ($pemesanan) {
                $pemesanan->status_pembayaran = $request->transaction_status;
                $pemesanan->metode_pembayaran = $request->payment_type;
                $pemesanan->save();
            }

            return response()->json(['message' => 'Success']);
        } else {
            return response()->json(['message' => 'Invalid signature'], 403);
        }
    }

    public function finish(Request $request)
    {
        return redirect()->route('home'); // Mengarahkan ke halaman utama
    }
}
