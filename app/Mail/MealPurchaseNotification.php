<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MealPurchaseNotification extends Mailable {
    use Queueable, SerializesModels;

    public $meal;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meal) {
        $this->meal = $meal;
        $this->user = Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->to($this->user->email, "{$this->user->name}")
            ->subject('Meal Purchased!')
            ->view('emails.meal_purchase');
    }
}
