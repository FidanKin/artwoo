<?php

namespace App\Providers;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\WriteLogDB;
use Illuminate\Auth\Events\Registered;
use Source\Entity\Artwork\Events\ArtworkCreatedSuccessfully;
use Source\Entity\Artwork\Events\Handlers\AddWatermarksToArtworkImages;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
//        UserCreated::class => [
//          SendEmailVerificationNotification::class,
//            WriteLogDB::class,

//        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ArtworkCreatedSuccessfully::class => [
            AddWatermarksToArtworkImages::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @todo посмотреть, как первым аргументом передать нашу директорию приложения
     */
    public function boot(): void
    {
        Event::listen('*', function (string $eventName, array $data) {
            $event = $data[0];
            if ($event instanceof \Source\Event\AbstractEvent) {
                (new WriteLogDB())->handle($event);
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
