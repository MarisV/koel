<?php

namespace App\Listeners;

use Illuminate\Events\Dispatcher;

class JWTEventListener
{
    /**
     * @param Dispatcher $event
     */
    public function onValidUser(Dispatcher $event): void
    {
        auth()->setUser($event->user);
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen('tymon.jwt.valid', self::class.'@onValidUser');
    }
}
