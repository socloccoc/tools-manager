<?php


namespace Informatics\Base\Providers;


use \Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        \Illuminate\Log\Events\MessageLogged::class => [
            \App\Listeners\Logger::class
        ]

    ];
}