<?php

namespace RickSelby\Laravel\GateCache;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

class GateCacheProvider extends ServiceProvider
{
    public function register()
    {
        // Rebind GateContract to GateCache
        $this->app->singleton(GateContract::class, function ($app) {
            return new GateCache($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });
    }
}
