<?php

namespace App\Providers;

use App\Events\CustomerCreated;
use App\Events\CustomerUpdated;
use App\Listeners\CustomerCreatedListener;
use App\Listeners\CustomerUpdatedListener;
use App\Models\Customer;
use App\Observers\CustomerObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CustomerCreated::class => [
            CustomerCreatedListener::class
        ],
        CustomerUpdated::class => [
            CustomerUpdatedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Customer::observe(CustomerObserver::class);
        Customer::observe(CustomerUpdated::class);
    }
}
