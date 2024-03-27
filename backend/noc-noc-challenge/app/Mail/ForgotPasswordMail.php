<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $passwordResetUrl;

    public function __construct($passwordResetUrl)
    {
        $this->passwordResetUrl = $passwordResetUrl;
    }

    public function build()
    {
        return $this->view('emails.forgot')->with([ 'passwordResetUrl' => $this->passwordResetUrl ]);
    }
}
