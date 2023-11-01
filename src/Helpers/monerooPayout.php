<?php

use Moneroo\Laravel\Payout;

function monerooPayout(): Payout
{
    return new Moneroo\Laravel\Payout();
}
