<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reminderDate;
    public $community_id;
    public $name;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reminderDate,$community_id,$name)
    {
        $this->reminderDate = $reminderDate;
        $this->community_id = $community_id;
        $this->name =$name;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        return $this->view('mail.remender')
        ->with([
           'date' => $this->reminderDate,
           'community_id' => $this->community_id,
           'name'=>$this->name
        ]);
    }
}
