<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimMail extends Mailable
{
    use Queueable, SerializesModels;
    // public $name;
    // public $email;

    // public $start_at;
    // public $end_at;
    // public $code;
    // public $peroid;
    public $claim;
    public $link;

    // public $password;

   
    public function __construct($claim,$link)
    {
        // $this->name = $name;
        // $this->email = $email;

        // $this->start_at = $start_at;
        // $this->end_at = $end_at;
        // $this->code = $code;
        // $this->peroid =$peroid;
        $this->claim = $claim;
        $this->link= $link;

        // $this->password = $password;

    }
    public function build()
    {
        return $this->view('mail.claim')
        ->with([
            'claim_id'=>$this->claim,
            'link'=>$this->link,

        //    'name' => $this->name,
        //    'email'=>$this->email,
        //    'start_at' => $this->start_at,
        //    'end_at'=>$this->end_at,
        //    'code'=>$this->code,
        //    'peroid'=>$this->peroid
        //    'password' => $this->password
        ]);
    }

          
      
}

