<?php

use Moneroo\Laravel\Payment;

function monerooPayment(): Payment
{
    return new Moneroo\Laravel\Payment();
}
