<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertSubscribe extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $date;
    public $message;

    // public $password;


   
    public function __construct($name,$email,$date,$message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->date = $date;
        $this->message = $message;

        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.alert_sub')
        ->with([
           'name' => $this->name,
           'email' => $this->email,
           'date'=>$this->date,
           'message'=>htmlspecialchars($this->message)
        //    'password' => $this->password
        ]);
    }

          
      
}

