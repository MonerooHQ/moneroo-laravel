<?php

namespace Moneroo\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Moneroo\Providers\MonerooServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithFaker;

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
