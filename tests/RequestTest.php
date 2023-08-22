<?php

namespace Moneroo\Tests;

use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Moneroo\Exceptions\ForbiddenException;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Exceptions\InvalidResourceException;
use Moneroo\Exceptions\NotAcceptableException;
use Moneroo\Exceptions\ServerErrorException;
use Moneroo\Exceptions\UnauthorizedException;
use Moneroo\Moneroo;

class RequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Config::set('moneroo.publicKey', 'testPublicKey');
        Config::set('moneroo.secretKey', 'testSecretKey');
    }

    /**
     * It should make HTTP request.
     *
     * @test
     */
    public function it_should_make_http_request(): void
    {
        Event::fake();

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => true,
                'data'    => [
                    'id' => 1,
                ],
            ]),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');

        Event::assertDispatched(RequestSending::class, static function (RequestSending $event) {
            return $event->request->url() === 'https://api.moneroo.io/v1/test' &&
                $event->request->method() === 'POST' &&
                $event->request->data() === ['four' => 'bar'];
        });
    }

    /**
     * It should throw UnauthorizedException if the response status code is 401.
     *
     * @test
     */
    public function it_should_throw_unauthorized_exception_if_the_response_status_code_is_401(): void
    {
        $this->expectException(UnauthorizedException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 401),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');
    }

    /**
     * It should throw ForbiddenException if the response status code is 403.
     *
     * @test
     */
    public function it_should_throw_forbidden_exception_if_the_response_status_code_is_403(): void
    {
        $this->expectException(ForbiddenException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 403),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');
    }

    /**
     * It should throw InvalidResourceException if the response status code is 404.
     *
     * @test
     */
    public function it_should_throw_invalid_resource_exception_if_the_response_status_code_is_404(): void
    {
        $this->expectException(InvalidResourceException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 404),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');
    }

    /**
     * It should throw InvalidPayloadException if the response status code is 400 or 422.
     *
     * @test
     */
    public function it_should_throw_invalid_payload_exception_if_the_response_status_code_is_400_or_422(): void
    {
        $this->expectException(InvalidPayloadException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 400),
            'https://api.moneroo.io/v1/test-2' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 422),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test-2');
    }

    /**
     * It should throw NotAcceptableException if the response status code is 406.
     *
     * @test
     */
    public function it_should_throw_not_acceptable_exception_if_the_response_status_code_is_406(): void
    {
        $this->expectException(NotAcceptableException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 406),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');
    }

    /**
     * It should throw ServerErrorException if the response status code is 500.
     *
     * @test
     */
    public function it_should_throw_server_error_exception_if_the_response_status_code_is_500(): void
    {
        $this->expectException(ServerErrorException::class);

        Http::fake([
            'https://api.moneroo.io/v1/test' => Http::response([
                'success' => false,
                'data'    => [
                    'id' => 1,
                ],
            ], 500),
        ]);

        $moneroo = new Moneroo();

        $moneroo->sendRequest('POST', ['four' => 'bar'], 'test');
    }
}
