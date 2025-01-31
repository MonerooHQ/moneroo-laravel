<?php

namespace Moneroo\Laravel;

use Exception;
use Illuminate\Support\Facades\Validator;
use Moneroo\Laravel\Exceptions\InvalidPayloadException;

class Moneroo
{
    use Traits\Request;

    /**
     *  API secret key.
     */
    protected ?string $secretKey;

    /**
     *  API base URL.
     */
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('moneroo.secretKey');

        $this->baseUrl = config('moneroo.devMode') === true
            ? config('moneroo.devBaseUrl')
            : Config::BASE_URL;

        if (empty($this->secretKey) || ! is_string($this->secretKey)) {
            throw new InvalidPayloadException('Moneroo secret key is not set or not a string.');
        }
    }

    /**
     * Validate the data  with Laravel validator.
     *
     * @param array $data - The data to validate
     * @param array $rules - The rules to validate against
     */
    public function validateData(array $data, array $rules): void
    {
        try {
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                throw new InvalidPayloadException(implode(', ', $validator->errors()->all()));
            }
        } catch (Exception $e) {
            throw new InvalidPayloadException($e->getMessage());
        }
    }
}
