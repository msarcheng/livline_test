<?php

namespace App\Providers;

use App\Http\Services\TaskInterface;
use App\Http\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskInterface::class, TaskService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
