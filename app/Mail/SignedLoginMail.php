<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignedLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $url) {}

    public function build()
    {
        return $this->subject('Two-Factor Authentication')
            ->markdown('mail.signed-login')->with(['url' => $this->url]);
    }
}
