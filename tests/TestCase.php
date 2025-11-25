<?php

namespace Moneroo\Laravel\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Moneroo\Laravel\Providers\MonerooServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithFaker;

    /**
     * The last response returned by the application.
     *
     * @var null|TestResponse
     */
    public static $latestResponse;

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
