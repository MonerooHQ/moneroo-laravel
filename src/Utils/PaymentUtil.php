<?php

namespace Moneroo\Utils;

class PaymentUtil
{
    public static function getMethods(): array
    {
        return [
            'orange_ci'            => [
                'currency'           => 'XOF',
                'countries'          => ['CI'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'orange_sn'            => [
                'currency'           => 'XOF',
                'countries'          => ['SN'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'orange_bf'            => [
                'currency'           => 'XOF',
                'countries'          => ['BF'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'orange_ml'            => [
                'currency'           => 'XOF',
                'countries'          => ['ML'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'e_money_sn' => [
                'currency'           => 'XOF',
                'countries'          => ['SN'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'orange_cm' => [
                'currency'           => 'XAF',
                'countries'          => ['CM'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'eu_mobile_cm' => [
                'currency'           => 'XAF',
                'countries'          => ['CM'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_cm' => [
                'currency'           => 'XAF',
                'countries'          => ['CM'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_bj'           => [
                'currency'           => 'XOF',
                'countries'          => ['BJ'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_ci'           => [
                'currency'           => 'XOF',
                'countries'          => ['CI'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'airtel_ng'       => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'moov_bj'          => [
                'currency'           => 'XOF',
                'countries'          => ['BJ'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'moov_bf'          => [
                'currency'           => 'XOF',
                'countries'          => ['BF'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'moov_tg'          => [
                'currency'           => 'XOF',
                'countries'          => ['TG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'moov_ci'          => [
                'currency'           => 'XOF',
                'countries'          => ['CI'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'moov_ml' => [
                'currency'           => 'XOF',
                'countries'          => ['ML'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'togocel'          => [
                'currency'           => 'XOF',
                'countries'          => ['TG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_ngn'         => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_usd'         => [
                'currency'           => 'USD',
                'countries'          => ['US'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_ghs'         => [
                'currency'           => 'GHS',
                'countries'          => ['GH'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_xof'         => [
                'currency'           => 'XOF',
                'countries'          => ['CI', 'BF', 'TG', 'BJ', 'ML'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_xaf'         => [
                'currency'           => 'XAF',
                'countries'          => ['CM', 'CF', 'CG', 'GA', 'GQ', 'TD'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_zar'         => [
                'currency'           => 'ZAR',
                'countries'          => ['ZA'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'wave_ci'          => [
                'currency'           => 'XOF',
                'countries'          => ['CI'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'wave_sn'          => [
                'currency'           => 'XOF',
                'countries'          => ['SN'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'freemoney_sn'     => [
                'currency'           => 'XOF',
                'countries'          => ['SN'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_ng'           => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_gh'           => [
                'currency'           => 'GHS',
                'countries'          => ['GH'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mobi_cash_bf' => [
                'currency'           => 'XOF',
                'countries'          => ['BF'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mobi_cash_ml' => [
                'currency'           => 'XOF',
                'countries'          => ['ML'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'airtel_ne'       => [
                'currency'           => 'XOF',
                'countries'          => ['NE'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'mtn_gf'           => [
                'currency'           => 'GNF',
                'countries'          => ['GN'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'airtel_gh'       => [
                'currency'           => 'GHS',
                'countries'          => ['GH'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'vodafone_gh' => [
                'currency'           => 'GHS',
                'countries'          => ['GH'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'barter' => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'ussd_ngn' => [
                'name'               => 'USSD NGN',
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'qr_ngn' => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'bank_transfer_ng' => [
                'currency'           => 'NGN',
                'countries'          => ['NG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_kes' => [
                'currency'           => 'KES',
                'countries'          => ['KE'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_tzs' => [
                'currency'           => 'TZS',
                'countries'          => ['TZ'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
            ],
            'card_ugx' => [
                'currency'           => 'UGX',
                'countries'          => ['UG'],
                'min_amount'         => 100,
                'max_amount'         => 1000000,
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
}
