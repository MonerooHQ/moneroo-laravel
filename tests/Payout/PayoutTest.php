<?php

namespace Moneroo\Tests\Payout;

use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Payout;
use Moneroo\Tests\TestCase;

class PayoutTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['moneroo.publicKey' => 'test']);
        config(['moneroo.secretKey' => 'test']);
        config(['moneroo.devMode' => false]);
    }

    /**
     * It should create a payout.
     *
     * @test
     */
    public function it_should_create_a_payout(): void
    {
        Event::fake();

        $testAccountNumber = [
            233541234567,
            22961000000,
            2250577100000,
        ];

        $methodCode = 'moneroo_payout_demo';

        Http::fake([
            'https://api.moneroo.io/v1/payouts/initialize' => Http::response([
                'success' => true,
                'data' => [
                    'id' => 1,
                ],
            ]),
        ]);

        $payoutData = [
            'amount' => 100,
            'currency' => $this->faker->currencyCode(),
            'description' => 'Test payout',
            'customer' => [
                'email' => $this->faker->email(),
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
            ],
            'method' => $methodCode,
            'account_number' => $this->faker->randomElement($testAccountNumber),
        ];

        $payout = new Payout();

        $transaction = $payout->create($payoutData);

        $this->assertEquals(1, $transaction->id);

        Event::assertDispatched(RequestSending::class, static function (RequestSending $event) use ($payoutData) {
            return $event->request->url() === 'https://api.moneroo.io/v1/payouts/initialize'
                && $event->request->method() === 'POST'
                && $event->request->data() === $payoutData;
        });
    }

    /**
     * It should return error if validation fails.
     *
     * @test
     */
    public function it_should_return_error_if_validation_fails(): void
    {
        $payout = new Payout();

        $this->expectException(InvalidPayloadException::class);

        $payout->create([]);
    }
}
