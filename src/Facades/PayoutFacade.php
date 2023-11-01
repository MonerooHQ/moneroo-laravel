<?php

namespace Moneroo\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class PayoutFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payout';
    }
}
