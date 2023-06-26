<?php

namespace AxaZara\Moneroo\Utils;

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
                        'name'       => 'phone',
                        'validation' => 'required|numeric|starts_with:229|digits:11',
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
                        'name'       => 'phone',
                        'validation' => 'required|dd|starts_with:229|digits:11',
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

    public static function getMethodFieldsValidationRules(string $method): array
    {
        $methods = self::getMethods()[$method];

        if (! $methods) {
            throw new \RuntimeException("Payout method '$method' does not exist.");
        }

        $fields = $methods['fields'];

        return collect($fields)->mapWithKeys(function ($field) {
            return [$field['name'] => $field['validation']];
        })->toArray();
    }
}
