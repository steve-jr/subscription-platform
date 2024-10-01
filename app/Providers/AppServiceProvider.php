<?php

namespace App\Providers;

use App\Contract\PostServiceContract;
use App\Contract\SubscriptionServiceContract;
use App\Services\PostService;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscriptionServiceContract::class, SubscriptionService::class);
        $this->app->bind(PostServiceContract::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
