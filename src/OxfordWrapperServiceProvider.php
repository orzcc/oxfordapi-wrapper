<?php

namespace Inani\OxfordApiWrapper;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class OxfordWrapperServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Config
        $this->mergeConfigFrom(__DIR__ . '/../config/oxford.php', 'oxford');

        $this->app->singleton(Client::class, function() {
            return new Client([
                'base_uri' => config('oxford.api_base_uri'),
                'headers' => [
                    "app_id" => config('oxford.app_id'),
                    "app_key" => config('oxford.app_key')
                ]
            ]);
        });

        $this->app->bind(OxfordWrapper::class, function ($app){
            $client = $app->make(Client::class);
            return new OxfordWrapper($client, config('oxford.lang'));
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/oxford.php' => config_path('oxford.php'),
            ],
            'oxford-config'
        );
    }
}
