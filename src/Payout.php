<?php

namespace Moneroo;

final class Payout extends Moneroo
{
    /**
     * Initialize a payout.
     *
     * @param array $data - Array of data to be sent
     *
     * @see https://docs.moneroo.io/sdks/laravel#initialize-payout
     */
    public function init(array $data)
    {
        $this->validateData($data, $this->payoutValidationRules());

        return $this->sendRequest('post', $data, '/payouts/initialize');
    }

    /**
     * Verify a payout.
     *
     * @param string $payoutTransactionId - Payout transaction id
     *
     * @see https://docs.moneroo.io/sdks/laravel#verify-payout
     */
    public function verify(string $payoutTransactionId)
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId . '/verify');
    }

    /**
     * Retrieve payout details.
     *
     * @param string $payoutTransactionId - Payout transaction id
     *
     * @see https://docs.moneroo.io/sdks/laravel#retrieve-payout
     */
    public function get(string $payoutTransactionId)
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId);
    }

    /**
     * Payout validation rules.
     */
    private function payoutValidationRules(): array
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
            'metadata.*'          => ['string'],
            'method'              => ['required', 'string'],
        ];
    }
}
