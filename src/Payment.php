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
        $this->validateData($data, $this->paymentValidationRules());

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

    /**
     * Payment validation rules.
     */
    private function paymentValidationRules(): array
    {
        return [
            'amount'              => 'required|numeric|gt:0',
            'currency'            => ['required', 'string'],
            'description'         => ['string', 'required', 'max:155'],
            'customer'            => 'required|array',
            'customer.*'          => 'string',
            'customer.email'      => 'email|required',
            'customer.first_name' => 'string|max:100|required',
            'customer.last_name'  => 'string|max:100|required',
            'customer.phone'      => 'integer|nullable',
            'customer.address'    => 'string|max:200|nullable',
            'customer.city'       => 'string|max:100|nullable',
            'customer.state'      => 'string|max:100|nullable',
            'customer.country'    => 'string|max:10|nullable',
            'customer.zip'        => 'string|max:100|nullable',
            'metadata'            => ['array', 'max:10', 'nullable'],
            'methods'             => ['nullable', 'array'],
            'methods.*'           => ['string'],
        ];
    }
}
