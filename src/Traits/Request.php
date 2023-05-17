<?php

namespace AxaZara\Moneroo\Traits;

use AxaZara\Moneroo\Config;
use AxaZara\Moneroo\Exceptions\RequestError;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait Request
{
    private string $queue;

    private array $body = [];

    private string $method;

    private string $endpoint;

    public mixed $response;

    private function makeRequest(): bool
    {
        if ($this->apiUrl === 'test') {
            Log::error('Moneroo :: You are using the test mode, no request has made to Moneroo API, please check your config file.');

            $this->response = (object) [
                'lead' => [],
                'products' => [],
                'product' => [],
                'field' => [],
                'fields' => [],
                'THIS IS A TEST RESPONSE',
            ];

            return true;
        }

        $this->validate();

        $payload = [
            'method' => $this->method,
            'body' => $this->body,
            'url' => $this->apiUrl.$this->endpoint,
        ];

        return $this->dispatch($payload);
    }

    private function validate(): void
    {
        Config::validateApiUrl($this->apiUrl);
        Config::validateApiKey($this->apiKey);
    }

    private function dispatch(array $payload): bool
    {
        $this->payload = (object) $payload;

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => config('Moneroo.api_key'),
                ])->withBody(json_encode($this->payload->body, JSON_THROW_ON_ERROR), 'application/json')
                ->{$this->payload->method}($this->payload->url);

            $this->response = (object) $response->json();

            if ($response->failed()) {
                $this->lastError = $response->body() ?? 'Unknown error';
                Log::error('Moneroo Error :: '.$this->lastError.' URL :: '.$this->payload->url.' Request Body :: '.json_encode($this->payload->body, JSON_THROW_ON_ERROR));

                return false;
            }

            return true;
        } catch (Exception $e) {
            Log::error('Moneroo :: Exception :'.$e->getMessage());
            throw new RequestError($e->getMessage());
        }
    }
}
