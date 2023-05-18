<?php

namespace AxaZara\Moneroo\Tests;

use AxaZara\Moneroo\Providers\MonerooServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MonerooServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.debug', 'true');
    }
}
