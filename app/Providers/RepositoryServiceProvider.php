<?php

namespace App\Providers;

use App\Repositories\Implementations\OrderProductRepositoryImpl;
use App\Repositories\Implementations\OrderRepositoryImpl;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderRepository::class, OrderRepositoryImpl::class);
        $this->app->singleton(OrderProductRepository::class, OrderProductRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
