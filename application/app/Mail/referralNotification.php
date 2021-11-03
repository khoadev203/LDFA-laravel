<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Otp;
use Auth;

class referralNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_to;
    public $new_user_email;

    public function __construct($mail_to, $new_user_email)
    {
        $this->mail_to = $mail_to;
        $this->new_user_email = $new_user_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
       
        return $this->view('email.referralNotification')->subject('You have a new user with your referral link in '. setting('site.site_name'))->with("email", $this->new_user_email)->to($this->mail_to);
    }
}
