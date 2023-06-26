<?php

namespace AxaZara\Moneroo;

use AxaZara\Moneroo\Rules\Payment\ValidatePaymentCurrencyExists;
use AxaZara\Moneroo\Rules\Payment\ValidatePaymentMethods;

class Payment extends Moneroo
{
    public function create(array $data): object
    {
        $this->validateData($data, $this->paymentValidationRules());

        return $this->sendRequest('post', $data, '/payments/initialize');
    }

    public function verify(string $paymentTransactionId): object
    {
        return $this->sendRequest('get', [], '/payments/' . $paymentTransactionId . '/verify');
    }

    public function get(string $paymentTransactionId): object
    {
        return $this->sendRequest('get', [], '/payments/' . $paymentTransactionId);
    }

    public function markAsProcessed(string $paymentTransactionId): object
    {
        return $this->sendRequest('post', [], '/payments/' . $paymentTransactionId . '/process');
    }

    private function paymentValidationRules(): array
    {
        return [
            'amount'                 => 'required|integer',
            'currency'               => ['required', 'string', new ValidatePaymentCurrencyExists()],
            'customer'               => 'required|array',
            'customer.email'         => 'required|string',
            'customer.first_name'    => 'required|string',
            'customer.last_name'     => 'required|string',
            'customer.phone'         => 'string',
            'customer.address'       => 'string',
            'customer.city'          => 'string',
            'customer.state'         => 'string',
            'customer.country'       => 'string',
            'customer.zip'           => 'string',
            'description'            => 'string|max:155',
            'return_url'             => 'required|string|url',
            'metadata'               => 'nullable|array',
            'metadata.*'             => 'string',
            'methods'                => ['nullable', 'array', new ValidatePaymentMethods()],
        ];
    }
}
