<?php

namespace Moneroo\Providers;

use Illuminate\Support\ServiceProvider;
use Moneroo\Console;
use Moneroo\Facades;
use Moneroo\Moneroo;
use Moneroo\Payment;
use Moneroo\Payout;

class MonerooServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once __DIR__.'/../Helpers/monerooPayment.php';
        require_once __DIR__.'/../Helpers/monerooPayout.php';

        $this->app->bind('moneroo', function () {
            return new Moneroo();
        });

        $this->app->singleton('payment', function ($app) {
            return new Payment();
        });

        $this->app->singleton('payout', function ($app) {
            return new Payout();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
            ]);
            $this->publishes([
                __DIR__.'/../../config/moneroo-laravel.php' => config_path('moneroo.php'),
            ], 'config');
        }

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Moneroo', Facades\Moneroo::class);
            $loader->alias('Payment', Facades\PaymentFacade::class);
            $loader->alias('Payout', Facades\PayoutFacade::class);
        });
    }
}
