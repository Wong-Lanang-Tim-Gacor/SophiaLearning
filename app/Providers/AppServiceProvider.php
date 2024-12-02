<?php

namespace App\Providers;

use App\Contracts\Interface\AssignmentInterface;
use App\Contracts\Interface\ClassroomInterface;
use App\Contracts\Repository\AssignmentRepository;
use App\Contracts\Repository\ClassroomRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    private array $register = [
        ClassroomInterface::class => ClassroomRepository::class,
        AssignmentInterface::class => AssignmentRepository::class
    ];
    public function register(): void
    {
        foreach ($this->register as $index => $value) $this->app->bind($index, $value);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
