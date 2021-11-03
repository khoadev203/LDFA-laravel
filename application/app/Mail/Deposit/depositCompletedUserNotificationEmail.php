<?php

namespace App\Mail\Deposit;

use App\User;
use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Receive;

class depositCompletedUserNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $receive, $user; 

    public function __construct(Receive $receive, User $user)
    {
        $this->receive = $receive;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Deposit completed')->view('email.deposit.depositCompletedUserNotificationEmail')->with('receive', $this->receive)->with('user', $this->user)->to($this->user->email);
    }
}
