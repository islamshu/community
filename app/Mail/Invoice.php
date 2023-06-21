<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;

    public $start_at;
    public $end_at;
    public $code;
    public $peroid;
    public $invoice;

    // public $password;

   
    public function __construct($name,$email,$start_at,$end_at,$code,$peroid,$invoice)
    {
        $this->name = $name;
        $this->email = $email;

        $this->start_at = $start_at;
        $this->end_at = $end_at;
        $this->code = $code;
        $this->peroid =$peroid;

        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.invloce')
        ->with([
            'sub'=>$this->invoice,
           'name' => $this->name,
           'email'=>$this->email,
           'start_at' => $this->start_at,
           'end_at'=>$this->end_at,
           'code'=>$this->code,
           'peroid'=>$this->peroid
        //    'password' => $this->password
        ]);
    }

          
      
}

