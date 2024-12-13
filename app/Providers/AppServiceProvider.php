<?php

namespace App\Providers;

use App\Console\Commands\MakeInterface;
use App\Console\Commands\MakeRepository;
use App\Contracts\Interfaces\AnswerInterface;
use App\Contracts\Interfaces\AssignmentChatInterface;
use App\Contracts\Interfaces\AssignmentInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\MaterialInterface;
use App\Contracts\Repositories\AnswerRepository;
use App\Contracts\Repositories\AssignmentChatRepository;
use App\Contracts\Repositories\AssignmentRepository;
use App\Contracts\Repositories\ClassroomRepository;
use App\Contracts\Repositories\MaterialRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    private array $register = [
        ClassroomInterface::class => ClassroomRepository::class,
        AssignmentInterface::class => AssignmentRepository::class,
        AssignmentChatInterface::class => AssignmentChatRepository::class,
        AnswerInterface::class => AnswerRepository::class,
        MaterialInterface::class => MaterialRepository::class,
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
