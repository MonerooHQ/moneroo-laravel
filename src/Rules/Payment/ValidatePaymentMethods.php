<?php

namespace AxaZara\Moneroo\Rules\Payment;

use AxaZara\Moneroo\Utils\PaymentUtil;
use Illuminate\Contracts\Validation\Rule;

class ValidatePaymentMethods implements Rule
{
    protected array $paymentMethods;

    protected string $errorMessage = '';

    public function __construct()
    {
        $this->paymentMethods = PaymentUtil::getMethods();
    }

    public function passes($attribute, $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (! is_array($value)) {
            $this->errorMessage = 'Payment methods must be an array.';
            return false;
        }

        $currency = request()->input('currency');
        $country = request()->input('customer.country');
        $amount = request()->input('amount');

        foreach ($value as $method) {
            if (is_string($method)) {
                $method = strtolower($method);
            } else {
                $this->errorMessage = 'Payment methods must be an array of strings.';
                return false;
            }
            if (! isset($this->paymentMethods[$method])) {
                $this->errorMessage = "The payment method '{$method}' is invalid.";
                return false;
            }

            $paymentMethod = $this->paymentMethods[$method];

            if (isset($country) && ! in_array($country, $paymentMethod['countries'], true)) {
                $this->errorMessage = "The customer country '{$country}' is not compatible with the payment method '{$method}'.";
                return false;
            }

            if (isset($currency) && $currency !== $paymentMethod['currency']) {
                $this->errorMessage = "The currency '{$currency}' is not compatible with the payment method '{$method}'.";
                return false;
            }

            if (isset($amount) && ($amount < $paymentMethod['min_amount'] || $amount > $paymentMethod['max_amount'])) {
                $this->errorMessage = "The amount '{$amount}' is not within the acceptable range for the payment method '{$method}'.";
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return $this->errorMessage;
    }
}
