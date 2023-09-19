<?php

use Moneroo\Payment;

function monerooPayment(): Payment
{
    return new Moneroo\Payment();
}
