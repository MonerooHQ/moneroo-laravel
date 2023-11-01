<?php

namespace Moneroo\Laravel\Payment;

enum Status: string
{
    /**
     * The payment has been initiated.
     * This is transactional state and will change.
     */
    case INITIATED = 'initiated';

    /**
     * The payment is pending.
     * This is transactional state and will change.
     */
    case PENDING = 'pending';

    /**
     * The payment has failed.
     * This is final state.
     */
    case FAILED = 'failed';

    /**
     * The payment has been cancelled.
     * This is final state.
     */
    case SUCCESS = 'success';

    /**
     * The payment has been cancelled by user or abandoned (10 minutes after initiated state).
     * Should be treated as a failed payment.
     * This is final state.
     */
    case CANCELLED = 'cancelled';
}
