<?php

namespace AxaZara\Moneroo;

class Moneroo
{
    use Traits\Request;


    private object $payload;

    private ?string $apiKey;

    private ?string $apiUrl;

    private ?string $lastError = null;

    public function __construct()
    {
        $this->apiKey = config('Moneroo.api_key');
        $this->apiUrl = config('Moneroo.api_url');
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }
}
