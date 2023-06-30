<?php

namespace Moneroo\Rules\Payment;

use Illuminate\Contracts\Validation\Rule;
use Moneroo\Utils\PaymentUtil;

class ValidatePaymentCurrencyExists implements Rule
{
    protected array $paymentMethods;

    public function __construct()
    {
        $this->paymentMethods = PaymentUtil::getCurrencies();
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
