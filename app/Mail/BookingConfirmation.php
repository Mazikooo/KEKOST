<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesanan;

    public function __construct($pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Booking Anda Sukses')
                    ->view('emails.booking_confirmation');
    }
}
