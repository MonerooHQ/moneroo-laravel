<?php

namespace AxaZara\Moneroo;

use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use Exception;

class Payment extends Moneroo
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
                'callback_url'           => 'required|string|url',
                'metadata'               => 'nullable|array',
                'methods'                => 'nullable|array',
            ]);
        } catch (Exception $e) {
            throw new InvalidPayloadException($e->getMessage());
        }

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

    public function makeAsProcessed(string $paymentTransactionId): object
    {
        return $this->sendRequest('post', [], '/payments/' . $paymentTransactionId . '/process');
    }
}
