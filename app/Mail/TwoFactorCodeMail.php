<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code
    ){}

    public function build()
    {
        return $this->subject('Your 2FA Code')
            ->markdown('mail.two-factor-code')->with(['code' => $this->code]);
    }
}
