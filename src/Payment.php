<?php

namespace Moneroo\Laravel;

final class Payment extends Moneroo
{
    /**
     * Initialize payment.
     *
     * @param array $data - Array of data to be sent
     *
     * @see https://docs.moneroo.io/sdks/laravel#initialize-payment
     */
    public function init(array $data)
    {
        return $this->sendRequest(method: 'post', data: $data, endpoint: '/payments/initialize');
    }

    /**
     * Verify payment.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @see https://docs.moneroo.io/sdks/laravel#verify-payment
     */
    public function verify(string $paymentTransactionId)
    {
        return $this->sendRequest(method: 'get', data: [], endpoint: "/payments/$paymentTransactionId/verify");
    }

    /**
     * Retrieve payment details.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @see https://docs.moneroo.io/sdks/laravel#retrieve-payment
     */
    public function get(string $paymentTransactionId)
    {
        return $this->sendRequest(method: 'get', data: [], endpoint: "/payments/$paymentTransactionId");
    }

    /**
     * Mark payment as processed.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @note This is a beta feature, please contact us to enable it for your account.
     *
     * @see https://docs.moneroo.io/sdks/laravel#mark-payment-as-processed
     */
    public function markAsProcessed(string $paymentTransactionId)
    {
        return $this->sendRequest(method: 'post', data: [], endpoint: "/payments/$paymentTransactionId/process");
    }
}
