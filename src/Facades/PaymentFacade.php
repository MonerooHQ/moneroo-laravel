<?php

namespace Moneroo\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payment';
    }
}
