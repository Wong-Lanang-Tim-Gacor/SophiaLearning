<?php

namespace App\Providers;

use App\Console\Commands\MakeInterface;
use App\Console\Commands\MakeRepository;
use App\Contracts\Interfaces\AnswerInterface;
use App\Contracts\Interfaces\ChatInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\MaterialInterface;
use App\Contracts\Interfaces\ResourceInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\AnswerRepository;
use App\Contracts\Repositories\ChatRepository;
use App\Contracts\Repositories\ClassroomRepository;
use App\Contracts\Repositories\MaterialRepository;
use App\Contracts\Repositories\ResourceRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    private array $register = [
        ClassroomInterface::class => ClassroomRepository::class,
        ResourceInterface::class => ResourceRepository::class,
        ChatInterface::class => ChatRepository::class,
        AnswerInterface::class => AnswerRepository::class,
        MaterialInterface::class => MaterialRepository::class,
        UserInterface::class => UserRepository::class,
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
        $this->commands([
            MakeInterface::class,
            MakeRepository::class,
        ]);
    }
}
