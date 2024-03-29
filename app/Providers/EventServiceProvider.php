<?php

namespace App\Providers;

use App\Models\TeamsUsers;
use App\Models\Training;
use App\Models\User;
use App\Observers\TeamsUsersObserver;
use App\Observers\TrainingObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        //     // ... other providers
        //     \SocialiteProviders\GitHub\GitHubExtendSocialite::class.'@handle',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Training::observe(TrainingObserver::class);
        TeamsUsers::observe(TeamsUsersObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
