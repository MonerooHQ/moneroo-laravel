<?php

namespace AxaZara\Moneroo;

use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use AxaZara\Moneroo\Rules\Payout\ValidatePayoutCurrencyExists;
use AxaZara\Moneroo\Rules\Payout\ValidatePayoutMethod;
use AxaZara\Moneroo\Utils\PayoutUtil;
use Illuminate\Support\Facades\Validator;

class Payout extends Moneroo
{
    public function create(array $data): object
    {
        $this->validateData($data, $this->payoutValidationRules());

        $this->validatePayoutMethodRequiredFields($data);

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
        return [
            'amount'                 => 'required|integer',
            'currency'               => ['required', 'string', new ValidatePayoutCurrencyExists()],
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
            'method'                 => ['required', 'string', new ValidatePayoutMethod()],
        ];
    }

    private function validatePayoutMethodRequiredFields(array $data): void
    {
        if (! isset($data['method'])) {
            throw new InvalidPayloadException('Payout method is required.');
        }

        $validationRules = PayoutUtil::getMethodFieldsValidationRules($data['method']);

        $validator = Validator::make($data, $validationRules, [
            'required' => 'The ":attribute" field is required for this payout method.',
        ]);

        if ($validator->fails()) {
            throw new InvalidPayloadException($validator->errors()->first());
        }
    }
}
