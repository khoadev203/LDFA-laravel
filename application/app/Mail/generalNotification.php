<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class generalNotification extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $to_address, $message, $subject;

    public function __construct($subject, $message, $to_address)
    {
        $this->subject = $subject;
        $this->to_address = $to_address;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $this->to_address = "agiledev22@gmail.com";
        return $this->subject($this->subject)->view('email.generalNotification')->with('m_message', $this->message)->to($this->to_address);
    }
}