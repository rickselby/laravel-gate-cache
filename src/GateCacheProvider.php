<?php

namespace RickSelby\Laravel\GateCache;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

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
