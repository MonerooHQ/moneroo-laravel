<?php

namespace AxaZara\Moneroo;

use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use Exception;

class Payout extends Moneroo
{
    public function create(array $data): object
    {
        try {
            validator()->make($data, [
                'amount'                 => 'required|integer',
                'currency'               => 'required|string',
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
                'customer.ip'            => 'string',
                'description'            => 'string',
                'metadata'               => 'nullable|array',
                'method'                 => 'required|string',
            ]);
        } catch (Exception $e) {
            throw new InvalidPayloadException($e->getMessage());
        }

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
}
