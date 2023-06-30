<?php

namespace Moneroo\Facades;

use Illuminate\Support\Facades\Facade;

class PayoutFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payout';
    }
}
