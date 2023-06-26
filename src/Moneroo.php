<?php

namespace AxaZara\Moneroo;

use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use Exception;

class Moneroo
{
    use Traits\Request;

    protected ?string $publicKey;

    protected ?string $secretKey;

    public function __construct()
    {
        $this->publicKey = config('moneroo.publicKey');
        $this->secretKey = config('moneroo.secretKey');

        $this->validateConfig();
    }

    private function validateConfig(): void
    {
        if (empty($this->publicKey)) {
            throw new InvalidPayloadException('Moneroo public key is not set.');
        }

        if (empty($this->secretKey)) {
            throw new InvalidPayloadException('Moneroo secret key is not set.');
        }
    }

    public function validateData(array $data, $rules): void
    {
        try {
            $validation = validator()->make($data, $rules);

            if ($validation->fails()) {
                throw new InvalidPayloadException($validation->errors()->first());
            }
        } catch (Exception $e) {
            throw new InvalidPayloadException($e->getMessage());
        }
    }
}
