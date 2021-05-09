<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSignupNotification extends Mailable {
    use Queueable, SerializesModels;

    public $recipient = null;
    public $user = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $recipient, User $user) {
        $this->recipient = $recipient;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->to($this->recipient->email, "{$this->recipient->name}")
            ->subject('A New User Signup!')
            ->view('emails.new_signup');
    }
}
