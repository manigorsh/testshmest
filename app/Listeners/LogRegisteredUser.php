<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Transaction;

class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $transaction = new Transaction();
        $transaction->user_id = $event->user->id;
        $transaction->amount = 0;
        $transaction->balance = 0;
        $transaction->type = 'initial';
        $transaction->save();
    }
}
