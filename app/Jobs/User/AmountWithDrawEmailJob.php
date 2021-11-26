<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AmountWithDrawEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $userEmail = $this->userData->email;

            \Mail::send('emails.cook.amountWithdraw', function($message) use($userEmail) {
                $message->to($userEmail);
                $message->subject('Amount Withdraw Request');
            });
        }
        catch(\Exception $e) {
    
            //
        }
    }
}
