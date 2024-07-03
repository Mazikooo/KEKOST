<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $validated;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Selamat Datang di KEKOST!')
                    ->view('emails.welcome');
    }
}
