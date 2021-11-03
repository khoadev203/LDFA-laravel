<?php

namespace App\Mail\Certificate;

use App\User;
use App\Models\Buy_certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class orderDeliveredUserNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $certificate;
    public $user;
    public function __construct(Buy_certificate $certificate, User $user)
    {
        $this->user = $user;
        $this->certificate = $certificate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
          
        return $this->subject('Your order for Silver Certificates has been delivered')->view('emails.certificate_order_delivered')->with('certificate', $this->certificate)->with('user', $this->user)->to($this->user->email);
    
    }
}
