<?php

namespace Moneroo\Tests;

use Illuminate\Support\Facades\Bus;

class MonerooLaravelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Bus::fake();
    }

    public function testExample(): void
    {
        $this->assertTrue(true);
    }
}
