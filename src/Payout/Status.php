<?php

namespace Moneroo\Laravel\Payout;

enum Status: string
{
    /**
     * The payout has been initiated.
     * This is transactional state and will change.
     */
    case INITIATED = 'initiated';

    /**
     * The payout is pending, waiting for confirmation from PSP.
     *
     * This is transactional state and will change.
     */
    case PENDING = 'pending';

    /**
     * The payout has failed.
     *
     * This is final state.
     */
    case FAILED = 'failed';
}
