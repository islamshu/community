<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $message;
    
    // public $password;

   
    public function __construct($title,$message)
    {
        $this->title = $title;
        $this->message = $message;
        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.message')
        ->with([
           'title' => $this->title,
           'message' => $this->message,
        ]);
    }

          
      
}

