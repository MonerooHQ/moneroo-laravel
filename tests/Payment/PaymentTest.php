<?php

namespace Moneroo\Laravel\Tests\Payment;

use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Moneroo\Laravel\Exceptions\InvalidPayloadException;
use Moneroo\Laravel\Payment;
use Moneroo\Laravel\Tests\TestCase;

class PaymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['moneroo.publicKey' => 'test']);
        config(['moneroo.secretKey' => 'test']);
        config(['moneroo.devMode' => false]);
    }

    /**
     * It should init a payment.
     *
     * @test
     */
    public function it_should_init_a_payment(): void
    {
        Event::fake();

        Http::fake([
            'https://api.moneroo.io/v1/payments/initialize' => Http::response([
                'success' => true,
                'data'    => [
                    'id' => 1,
                ],
            ]),
        ]);

        $paymentData = [
            'amount'      => 100,
            'currency'    => 'XOF',
            'description' => 'Test payment',
            'customer'    => [
                'email'      => $this->faker->email(),
                'first_name' => $this->faker->firstName(),
                'last_name'  => $this->faker->lastName(),
            ],
            'return_url' => 'https://example.com/return',
        ];

        $payment = new Payment();

        $transaction = $payment->init($paymentData);

        $this->assertEquals(1, $transaction->id);

        Event::assertDispatched(RequestSending::class, static function (RequestSending $event) use ($paymentData) {
            return $event->request->url() === 'https://api.moneroo.io/v1/payments/initialize'
                && $event->request->method() === 'POST'
                && $event->request->data() === $paymentData;
        });
    }

    /**
     * It should return error if validation fails.
     *
     * @test
     */
    public function it_should_return_error_if_validation_fails(): void
    {
        $payment = new Payment();

        $this->expectException(InvalidPayloadException::class);

        $payment->init([]);
    }
}
