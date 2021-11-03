<?php

namespace App\Mail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Support extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_to, $text,$name;
     public function __construct($mail, $name , $text)
    {
        $this->mail_to = $mail;
        $this->text = $text;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.support')->subject('Help Request For '. setting('site.title'))->with('text', $this->text)->with('subject',$this->name)->to($this->mail_to);
    }
}
