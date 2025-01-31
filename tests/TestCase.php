<?php

namespace Moneroo\Laravel\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Moneroo\Laravel\Providers\MonerooServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithFaker;

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.debug', 'true');
    }

    protected function getPackageProviders($app): array
    {
        return [
            MonerooServiceProvider::class,
        ];
    }
}
