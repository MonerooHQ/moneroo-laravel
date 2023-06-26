<?php

namespace AxaZara\Moneroo\Rules\Payout;

use AxaZara\Moneroo\Utils\PayoutUtil;
use Illuminate\Contracts\Validation\Rule;

class ValidatePayoutMethod implements Rule
{
    protected array $payoutMethods;

    protected string $errorMessage = '';

    public function __construct()
    {
        $this->payoutMethods = PayoutUtil::getMethods();
    }

    public function passes($attribute, $value): bool
    {
        if (! is_string($value)) {
            $this->errorMessage = 'Payout method must be a strings.';
            return false;
        }

        $currency = request()->input('currency');
        $amount = request()->input('amount');

        if (! isset($this->payoutMethods[$value])) {
            $this->errorMessage = "The payout method '{$value}' is invalid.";
            return false;
        }

        $payoutMethod = $this->payoutMethods[$value];

        if (isset($currency) && $currency !== $payoutMethod['currency']) {
            $this->errorMessage = "The currency '{$currency}' is not compatible with the payout method '{$value}'.";
            return false;
        }

        if (isset($amount) && ($amount < $payoutMethod['min_amount'] || $amount > $payoutMethod['max_amount'])) {
            $this->errorMessage = "The amount '{$amount}' is not within the acceptable range for the payout method '{$value}'.";
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->errorMessage;
    }
}
