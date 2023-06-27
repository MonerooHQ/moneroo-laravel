<?php

namespace AxaZara\Moneroo\Tests;

use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use AxaZara\Moneroo\Payment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PaymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Mocking config values for tests
        Config::set('moneroo.publicKey', 'testPublicKey');
        Config::set('moneroo.secretKey', 'testSecretKey');
    }

    /**
     * Payment::create() should validate the provided data and send a request for payment initialization.
     *
     * @test
     */
    public function payment_creation_with_valid_data_is_successful(): void
    {
        $data = [
            'amount'   => 100,
            'currency' => 'USD',
            'customer' => [
                'email'      => 'test@test.com',
                'first_name' => 'Test',
                'last_name'  => 'User',
            ],
            'return_url' => 'http://example.com/return',
        ];

        Http::fake([
            '*/payments/initialize' => Http::response(['status' => 'success'], 200),
        ]);

        $payment = new Payment();

        $this->assertEquals((object) ['status' => 'success'], $payment->create($data));
    }

    /**
     * Payment::create() should throw an InvalidPayloadException when data does not meet the required rules.
     *
     * @test
     */
    public function payment_creation_with_invalid_data_throws_exception(): void
    {
        $this->expectException(InvalidPayloadException::class);

        $payment = new Payment();

        // Try with empty data
        $data = [];
        $payment->create($data);

        // Try with invalid types
        $data = [
            'amount'     => 'one hundred', // Should be integer
            'currency'   => ['currency' => 'USD'], // Should be string
            'customer'   => 'Test User', // Should be array
            'return_url' => 'not a URL', // Should be a valid URL
        ];
        $payment->create($data);

        // Try with missing fields
        $data = [
            'amount'   => 100,
            'currency' => 'USD',
            // 'customer' is missing
            'return_url' => 'http://example.com/return',
        ];
        $payment->create($data);
    }

    /**
     * Payment::verify() should send a request to verify a payment.
     *
     * @test
     */
    public function payment_verification_is_successful(): void
    {
        // Fake all Http requests and provide the expected responses
        Http::fake([
            '*/payments/*/verify' => Http::response(['status' => 'success'], 200),
        ]);

        $payment = new Payment();

        // Assert that verify() returns the expected result
        $this->assertEquals((object) ['status' => 'success'], $payment->verify('testTransactionId'));
    }

    /**
     * Payment::get() should send a request to get a payment.
     *
     * @test
     */
    public function getting_payment_details_is_successful(): void
    {
        // Fake all Http requests and provide the expected responses
        Http::fake([
            '*/payments/*' => Http::response(['status' => 'success'], 200),
        ]);

        $payment = new Payment();

        // Assert that get() returns the expected result
        $this->assertEquals((object) ['status' => 'success'], $payment->get('testTransactionId'));
    }

    /**
     * Payment::markAsProcessed() should send a request to mark a payment as processed.
     *
     * @test
     */
    public function marking_payment_as_processed_is_successful(): void
    {
        // Fake all Http requests and provide the expected responses
        Http::fake([
            '*/payments/*/process' => Http::response(['status' => 'success'], 200),
        ]);

        $payment = new Payment();

        // Assert that markAsProcessed() returns the expected result
        $this->assertEquals((object) ['status' => 'success'], $payment->markAsProcessed('testTransactionId'));
    }

    /**
     * Payment::markAsProcessed() should throw an exception when the payment transaction id is invalid.
     *
     * @test
     */
    public function marking_payment_as_processed_with_invalid_transaction_id_throws_exception(): void
    {
        $this->expectException(InvalidPayloadException::class);

        $payment = new Payment();

        // Try to mark a payment as processed with an invalid transaction id
        $payment->markAsProcessed('');
    }
}
