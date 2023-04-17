<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomRgister extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    
    // public $password;

   
    public function __construct($name,$email)
    {
        $this->name = $name;
        $this->email = $email;
        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.welcom_register')
        ->with([
           'name' => $this->name,
           'email' => $this->email,
        //    'password' => $this->password
        ]);
    }

          
      
}

