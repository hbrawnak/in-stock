<?php

namespace App\Listeners;

use App\Events\NowInStock;
use App\Notifications\ImportantStockUpdate;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(NowInStock $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
