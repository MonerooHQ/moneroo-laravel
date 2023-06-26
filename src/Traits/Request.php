<?php

namespace AxaZara\Moneroo\Traits;

use AxaZara\Moneroo\Config;
use AxaZara\Moneroo\Exceptions\ForbiddenException;
use AxaZara\Moneroo\Exceptions\InvalidPayloadException;
use AxaZara\Moneroo\Exceptions\InvalidResourceException;
use AxaZara\Moneroo\Exceptions\NotAcceptableException;
use AxaZara\Moneroo\Exceptions\ServerErrorException;
use AxaZara\Moneroo\Exceptions\ServiceUnavailableException;
use AxaZara\Moneroo\Exceptions\UnauthorizedException;
use Exception;
use Illuminate\Support\Facades\Http;

trait Request
{
    protected function sendRequest(string $method, array $data, string $endpoint): object
    {
        try {
            $request = $this->prepareRequest($method, $data, $endpoint);
            $payload = $this->decodePayload($request);

            return $this->processResponse($payload, $request);
        } catch (Exception $e) {
            throw new ServerErrorException($e->getMessage());
        }
    }

    private function prepareRequest(string $method, array $data, string $endpoint)
    {
        return Http::asJson()
            ->acceptJson()
            ->withUserAgent('Moneroo Laravel SDK v' . Config::VERSION)
            ->timeout(Config::TIMEOUT)
            ->withToken($this->secretKey, 'Bearer')
            ->baseUrl(Config::BASE_URL)
            ->$method($endpoint, $data);
    }

    private function decodePayload($request): object
    {
        return json_decode($request->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }

    private function processResponse(object $payload, $request): object
    {
        switch ($request->getStatusCode()) {
            case 201:
            case 200:
                return $payload->data;
            case 401:
                throw new UnauthorizedException($payload->message);
            case 403:
                throw new ForbiddenException($payload->message);
            case 404:
                throw new InvalidResourceException($payload->message);
            case 400:
            case 422:
                throw new InvalidPayloadException($payload->message);
            case 406:
                throw new NotAcceptableException($payload->message);
            case 503:
                throw new ServiceUnavailableException($payload->message);
            default:
                throw new ServerErrorException($payload->message);
        }
    }
}
