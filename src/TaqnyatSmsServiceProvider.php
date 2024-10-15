<?php

namespace Alsaloul\Taqnyat;

use Illuminate\Support\ServiceProvider;

class TaqnyatSmsServiceProvider extends ServiceProvider
{
    /**
     * Register the TaqnyatSms singleton instance.
     */
    public function register()
    {
        $this->app->singleton(TaqnyatSms::class, function ($app) {
            return new TaqnyatSms(config('taqnyat-sms.auth'));
        });
    }

    /**
     * Boot the package by publishing the configuration file.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/taqnyat-sms.php' => config_path('taqnyat-sms.php'),
        ]);
    }
}
