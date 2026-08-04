<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BlogServiceInterface;
use App\Services\BlogService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BlogServiceInterface::class, BlogService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
