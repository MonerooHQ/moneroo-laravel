<?php

namespace AxaZara\Moneroo\Rules\Payment;

use AxaZara\Moneroo\Utils\PaymentUtil;
use Illuminate\Contracts\Validation\Rule;

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
