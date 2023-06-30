<?php

namespace Moneroo\Tests\Payment;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use Moneroo\Tests\TestCase;
use Moneroo\Utils\PayoutUtil;

class ValidatePaymentMethodConfigTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Bus::fake();
    }

    /**
     * it should return be a valid payout method config.
     *
     * @test
     */
    public function it_should_be_a_valid_payout_method_config(): void
    {
        $payoutMethods = PayoutUtil::getMethods();

        $validationRules = [
            'currency'   => ['required', 'string'],
            'countries'  => ['required', 'array'],
            'min_amount' => ['required', 'integer', 'min:1'],
            'max_amount' => ['required', 'integer', 'gte:min_amount'],
        ];

        foreach ($payoutMethods as $payoutMethodCode => $details) {
            $validator = Validator::make($details, $validationRules);

            $this->assertTrue(
                $validator->passes(),
                "Validation failed for payout method '$payoutMethodCode': " . implode(', ', $validator->errors()->all())
            );

            $this->assertCount(count($details['countries']), array_unique($details['countries']), "Some countries are duplicated in 'countries' property for payout method '$payoutMethodCode'. Duplicate countries: " . implode(', ', array_diff_assoc($details['countries'], array_unique($details['countries']))));
        }
    }
}
