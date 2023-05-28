<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mess;
  
    
    // public $password;

   
    public function __construct($mess)
    {
        $this->mess = $mess;
        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.message');

    }

          
      
}

