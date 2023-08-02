<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubSubscribeNow2 extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $link;

    // public $password;


   
    public function __construct($name,$email,$link)
    {
        $this->name = $name;
        $this->email = $email;
        $this->link = $link;

        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.sub_now2')
        ->with([
           'name' => $this->name,
           'email' => $this->email,
           'link'=>$this->link
        //    'password' => $this->password
        ]);
    }

          
      
}

