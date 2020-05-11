<?php

namespace App\Providers;

use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ([
                     NotificationRepositoryInterface::class => NotificationRepository::class,
                     UserRepositoryInterface::class => UserRepository::class,
                 ] as $interface => $concrete) {

            app()->bind($interface, $concrete);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
