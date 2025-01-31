<?php

use Moneroo\Laravel\Payment;

function monerooPayment(): Payment
{
    return new Payment();
}
