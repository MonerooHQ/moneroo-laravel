<?php

namespace Moneroo\Tests;

use Illuminate\Support\Facades\Config;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Moneroo;

class MonerooTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Mocking config values for tests
        Config::set('moneroo.publicKey', 'testPublicKey');
        Config::set('moneroo.secretKey', 'testSecretKey');
    }

    /**
     * Moneroo::__construct() should create an instance of the Moneroo class with no errors.
     *
     * @test
     */
    public function moneroo_class_is_correctly_instantiated(): void
    {
        $moneroo = new Moneroo();

        $this->assertNotNull($moneroo);
    }

    /**
     * Moneroo::__construct() should throw an InvalidPayloadException when no public key is provided.
     *
     * @test
     */
    public function moneroo_class_throws_exception_when_public_key_is_missing(): void
    {
        $this->expectException(InvalidPayloadException::class);

        Config::set('moneroo.publicKey', null);

        new Moneroo();
    }

    /**
     * Moneroo::__construct() should throw an InvalidPayloadException when no secret key is provided.
     *
     * @test
     */
    public function moneroo_class_throws_exception_when_secret_key_is_missing(): void
    {
        $this->expectException(InvalidPayloadException::class);

        Config::set('moneroo.secretKey', null);

        new Moneroo();
    }

    /**
     * Moneroo::validateData() should validate the provided data according to the provided rules.
     *
     * @test
     */
    public function data_is_validated_according_to_provided_rules(): void
    {
        $moneroo = new Moneroo();
        $rules = ['key' => 'required'];
        $data = ['key' => 'value'];

        $moneroo->validateData($data, $rules);
        $this->assertTrue(true);
    }

    /**
     * Moneroo::validateData() should throw an InvalidPayloadException when data does not meet the provided rules.
     *
     * @test
     */
    public function validation_throws_exception_when_data_does_not_meet_rules(): void
    {
        $this->expectException(InvalidPayloadException::class);

        $moneroo = new Moneroo();
        $rules = ['key' => 'required'];
        $data = [];

        $moneroo->validateData($data, $rules);
    }
}
