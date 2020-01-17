<?php

namespace App\Listeners;

use App\Mail\TripSubscriptionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;


class TripSubscriptionEmailListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to('ahmad@example.com')->send(new TripSubscriptionMail());
    }
}
