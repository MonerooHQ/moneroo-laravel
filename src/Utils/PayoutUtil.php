<?php

namespace Moneroo\Utils;

class PayoutUtil
{
    public static function getMethods(): array
    {
        return [
            'mtn_bj'           => [
                'currency'      => 'XOF',
                'countries'     => ['BJ'],
                'min_amount'    => 100,
                'max_amount'    => 200000,
                'fields'        => [
                    [
                        'type'       => 'integer',
                        'name'       => 'momo_number',
                        'validation' => 'required|integer|starts_with:229|digits:11',
                    ],
                ],
            ],
            'moov_bj'         => [
                'currency'      => 'XOF',
                'countries'     => ['BJ'],
                'min_amount'    => 100,
                'max_amount'    => 200000,
                'fields'        => [
                    [
                        'type'       => 'integer',
                        'name'       => 'momo_number',
                        'validation' => 'required|integer|starts_with:229|digits:11',
                    ],
                ],
            ],
            'moneroo_payout_demo' => [
                'currency'           => 'USD',
                'countries'          => ['US'],
                'min_amount'         => 1,
                'max_amount'         => 200000,
                'fields'             => [
                    [
                        'type'       => 'string',
                        'name'       => 'account_number',
                        'validation' => 'required|integer|starts_with:229,233,225|min_digits:11|max_digits:13',
                    ],
                ],
            ],
        ];
    }

    public static function getCurrencies(): array
    {
        $methods = self::getMethods();

        return collect($methods)
            ->pluck('currency')
            ->unique()
            ->values()
            ->toArray();
    }

    public static function getMethodFieldsValidationRules(string $methodCode): array
    {
        $method = self::getMethods()[$methodCode];

        if (! $method) {
            throw new \RuntimeException("Payout method '$methodCode' does not exist.");
        }

        $fields = $method['fields'];

        return collect($fields)->mapWithKeys(function ($field) {
            return [$field['name'] => $field['validation']];
        })->toArray();
    }
}
