<?php

namespace AxaZara\Moneroo;

class Payout extends Moneroo
{
    public function create(array $data): object
    {
        $this->validateData($data, $this->payoutValidationRules());

        return $this->sendRequest('post', $data, '/payouts/initialize');
    }

    public function verify(string $payoutTransactionId): object
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId . '/verify');
    }

    public function get(string $payoutTransactionId): object
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId);
    }

    private function payoutValidationRules(): array
    {
        return  [
            'amount'                 => 'required|integer',
            'currency'               => 'required|string',
            'customer'               => 'required|array',
            'customer.email'         => 'required|string',
            'customer.first_name'    => 'required|string',
            'customer.last_name'     => 'required|string',
            'customer.phone'         => 'integer',
            'customer.address'       => 'string',
            'customer.city'          => 'string',
            'customer.state'         => 'string',
            'customer.country'       => 'string',
            'customer.zip'           => 'string',
            'description'            => 'string',
            'metadata'               => 'nullable|array',
            'metadata.*'             => 'string',
            'method'                 => 'required|string',
        ];
    }
}
