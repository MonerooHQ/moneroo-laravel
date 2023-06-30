<?php

namespace Moneroo;

use Moneroo\Rules\Payment\ValidatePaymentCurrencyExists;
use Moneroo\Rules\Payment\ValidatePaymentMethods;

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
            'amount'                 => 'required|numeric|gt:0',
            'currency'               => ['required', 'string', new ValidatePaymentCurrencyExists()],
            'description'            => ['string', 'required', 'max:155'],
            'customer'               => 'required|array',
            'customer.*'             => 'string',
            'customer.email'         => 'email|required',
            'customer.first_name'    => 'string|max:100|required',
            'customer.last_name'     => 'string|max:100|required',
            'customer.phone'         => 'integer|nullable',
            'customer.address'       => 'string|max:200|nullable',
            'customer.city'          => 'string|max:100|nullable',
            'customer.state'         => 'string|max:100|nullable',
            'customer.country'       => 'string|max:10|nullable',
            'customer.zip'           => 'string|max:100|nullable',
            'metadata'               => ['array', 'max:10', 'nullable'],
            'metadata.*'             => ['string'],
            'methods'                => ['nullable', 'array', new ValidatePaymentMethods()],
        ];
    }
}
