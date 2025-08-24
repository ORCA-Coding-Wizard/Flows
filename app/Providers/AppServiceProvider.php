<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StorageServiceInterface;
use App\Services\SupabaseStorageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StorageServiceInterface::class, SupabaseStorageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
