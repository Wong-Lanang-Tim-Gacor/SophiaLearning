<?php

namespace App\Providers;

use App\Contracts\Interface\ClassroomInterface;
use App\Contracts\Repository\ClassroomRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    private array $register = [
        ClassroomInterface::class => ClassroomRepository::class,
    ];
    public function register(): void
    {
        foreach ($this->register as $app) $this->app->bind($app[0], $app[1]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}