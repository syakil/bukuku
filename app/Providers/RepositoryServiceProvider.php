<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ScrapperInterface;
use App\Repositories\ScrapperRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ScrapperInterface::class, ScrapperRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
