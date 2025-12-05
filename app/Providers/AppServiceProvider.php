<?php

namespace App\Providers;

use App\Features\Properties\Contracts\PropertiesProvider;
use App\Features\Properties\Services\EasyBrokerClient;
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
        $this->app->bind(PropertiesProvider::class, EasyBrokerClient::class);
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
