<?php

namespace Leugin\RemoteAuth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Leugin\RemoteAuth\Dto\Configuration;

class RemoteAuthServiceProvider extends ServiceProvider
{


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Auth::provider('http', function ($app, array $config)
        {
            Log::info("ADAFAS");
            return new HttpUserProvider(Configuration::makeByArray($config));
        });
        Auth::extend('http', function (Application $app, string $name, array $config) {
            return new HttpGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request'),
            );
        });
    }
}
