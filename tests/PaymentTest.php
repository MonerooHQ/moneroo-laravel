<?php

namespace AxaZara\Moneroo\Tests;

use Illuminate\Support\Facades\Config;

class PaymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Config::set('moneroo.publicKey', 'testPublicKey');
        Config::set('moneroo.secretKey', 'testSecretKey');
    }
}
