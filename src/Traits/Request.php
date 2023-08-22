<?php

namespace Moneroo\Traits;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;
use JsonException;
use Moneroo\Config;
use Moneroo\Exceptions\ForbiddenException;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Exceptions\InvalidResourceException;
use Moneroo\Exceptions\NotAcceptableException;
use Moneroo\Exceptions\ServerErrorException;
use Moneroo\Exceptions\ServiceUnavailableException;
use Moneroo\Exceptions\UnauthorizedException;

trait Request
{
    public function sendRequest(string $method, array $data, string $endpoint): object
    {
        try {
            $request = Http::asJson()
                ->acceptJson()
                ->withUserAgent('Moneroo Laravel SDK v'.Config::VERSION)
                ->timeout(Config::TIMEOUT)
                ->withToken($this->secretKey, 'Bearer')
                ->baseUrl($this->baseUrl)
                ->$method($endpoint, $data);

            $payload = $this->decodePayload($request);

            return $this->processResponse($payload, $request);
        } catch (ConnectException|JsonException $e) {
            throw new ServerErrorException($e->getMessage());
        }
    }

    /**
     * @throws JsonException
     */
    private function decodePayload($request): object
    {
        return json_decode($request->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }

    private function processResponse(object $payload, $request): object
    {
        switch ($request->getStatusCode()) {
            case 201:
            case 200:
                return $payload->data ?? $payload;
            case 401:
                throw new UnauthorizedException($payload->message ?? 'Unauthorized, Status Code: '.$request->getStatusCode());
            case 403:
                throw new ForbiddenException($payload->message ?? 'Forbidden, Status Code: '.$request->getStatusCode());
            case 404:
                throw new InvalidResourceException($payload->message ?? 'Not Found, Status Code: '.$request->getStatusCode());
            case 400:
            case 422:
                throw new InvalidPayloadException($payload->message ?? 'Invalid Payload, Status Code: '.$request->getStatusCode());
            case 406:
                throw new NotAcceptableException($payload->message ?? 'Not Acceptable, Status Code: '.$request->getStatusCode());
            case 503:
                throw new ServiceUnavailableException($payload->message ?? 'Service Unavailable, Status Code: '.$request->getStatusCode());
            default:
                throw new ServerErrorException($payload->message ?? 'Server Error, Status Code: '.$request->getStatusCode());
        }
    }
}
