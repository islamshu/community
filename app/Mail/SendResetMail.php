<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetMail extends Mailable
{
    use Queueable, SerializesModels;
    public $code;
   
    public function __construct($code)
    {
        $this->code = $code;
    }
    public function build()
    {
        return $this->view('mail.rest')
        ->with([
           'otp' => $this->code->code
        ]);
    }

          
      
}
