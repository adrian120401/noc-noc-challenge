<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $passwordResetUrl;

    public function __construct($user, $passwordResetUrl)
    {
        $this->user = $user;
        $this->passwordResetUrl = $passwordResetUrl;
    }

    public function build()
    {
        return $this->view('emails.welcome')->with([ 'passwordResetUrl' => $this->passwordResetUrl, 'user' => $this->user]);
    }
}
