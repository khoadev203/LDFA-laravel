<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Send;

class sentPaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $send, $user; 

    public function __construct(Send $send, User $user)
    {
        $this->send = $send;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin_email = 'admin@ldfa.nl';
        return $this->subject('You sent payment')->view('email.sentPaymentNotificationEmail')->with('send', $this->send)->with('user', $this->user)->to($admin_email);
    }
}
