<?php

namespace Moneroo\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payment';
    }
}
