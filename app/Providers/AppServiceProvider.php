<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Eloquent\AuthRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
    );
    $this->app->bind(
    AuthRepositoryInterface::class,
    AuthRepository::class
);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
