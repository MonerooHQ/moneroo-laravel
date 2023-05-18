<?php

namespace AxaZara\Moneroo\Tests;

use Illuminate\Support\Facades\Bus;

class MonerooLaravelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Bus::fake();
    }
}
