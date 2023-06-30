<?php

namespace Moneroo\Rules\Payout;

use Illuminate\Contracts\Validation\Rule;
use Moneroo\Utils\PayoutUtil;

class ValidatePayoutCurrencyExists implements Rule
{
    protected array $paymentMethods;

    public function __construct()
    {
        $this->paymentMethods = PayoutUtil::getCurrencies();
    }

    public function passes($attribute, $value): bool
    {
        return in_array($value, $this->paymentMethods, true);
    }

    public function message(): string
    {
        return 'The selected currency is invalid.';
    }
}
