<?php

namespace AxaZara\Moneroo\Tests;

use AxaZara\Moneroo\Facades\Moneroo;
use Illuminate\Support\Facades\Bus;

class MonerooLaravelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Bus::fake();
    }

    /** @test */
    public function it_should_throw_an_exception_if_api_url_is_not_set(): void
    {
        $this->expectException(\AxaZara\Moneroo\Exceptions\InvalidApiUrl::class);

        config()->set('Moneroo.api_url');
        config()->set('Moneroo.api_key');
        Moneroo::createLead('test@test.com');
    }

    /** @test */
    public function it_should_throw_an_exception_if_api_token_key_is_not_set(): void
    {
        $this->expectException(\AxaZara\Moneroo\Exceptions\ApiKeyIsMissing::class);

        config()->set('Moneroo.api_url', 'https://api.Moneroo.com');
        config()->set('Moneroo.api_key');
        Moneroo::createLead('test@test.com');
    }
}
