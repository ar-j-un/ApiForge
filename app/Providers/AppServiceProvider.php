<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PostApiServiceInterface;
use App\Services\JsonPlaceholderPostService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostApiServiceInterface::class, JsonPlaceholderPostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
