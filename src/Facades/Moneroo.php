<?php

namespace Moneroo\Facades;

use Illuminate\Support\Facades\Facade;

class Moneroo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Moneroo';
    }
}
