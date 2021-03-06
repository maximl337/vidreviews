<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invite;
use App\User;

class SendInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invite $invite, User $user)
    {
        $this->invite = $invite;

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('accept-invite', [
            'token' => $this->invite->token,
            'email' => $this->invite->invitee_email
        ]);
        return $this->view('emails.invite')
                    ->subject($this->user->name . " invited you to leave a review")
                    ->with(['url' => $url]);
    }
}
