<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $sub;
    public $is_finish;
    
    // public $password;

   
    public function __construct($name,$sub,$is_finish)
    {
        $this->name = $name;
        $this->sub = $sub;
        $this->is_finish =$is_finish;
        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.order')
        ->with([
           'name' => $this->name,
           'sub' => $this->sub,
           'is_finish'=>$this->is_finish
        //    'password' => $this->password
        ]);
    }

          
      
}

