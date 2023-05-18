<?php

namespace AxaZara\Moneroo\Providers;

use AxaZara\Moneroo\Console;
use AxaZara\Moneroo\Facades;
use AxaZara\Moneroo\Moneroo;
use Illuminate\Support\ServiceProvider;

class MonerooServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('moneroo', function () {
            return new Moneroo();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
            ]);
            $this->publishes([
                __DIR__ . '/../config/moneroo-laravel.php' => config_path('moneroo.php'),
            ], 'config');
        }

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Moneroo', Facades\Moneroo::class);
        });
    }
}
