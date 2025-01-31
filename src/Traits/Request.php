<?php

namespace Moneroo\Laravel\Traits;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;
use JsonException;
use Moneroo\Laravel\Config;
use Moneroo\Laravel\Exceptions\ForbiddenException;
use Moneroo\Laravel\Exceptions\InvalidPayloadException;
use Moneroo\Laravel\Exceptions\InvalidResourceException;
use Moneroo\Laravel\Exceptions\NotAcceptableException;
use Moneroo\Laravel\Exceptions\ServerErrorException;
use Moneroo\Laravel\Exceptions\ServiceUnavailableException;
use Moneroo\Laravel\Exceptions\UnauthorizedException;

trait Request
{
    /**
     * Send request to the API.
     * Based on Laravel HTTP Client.
     *
     * @param string $method - The HTTP method to use (GET, POST, PUT, PATCH, DELETE)
     * @param array $data - The data to send
     * @param string $endpoint - The API endpoint
     */
    public function sendRequest(string $method, array $data, string $endpoint)
    {
        try {
            $request = Http::asJson()
                ->acceptJson()
                ->withUserAgent(userAgent: 'Moneroo Laravel SDK v' . Config::VERSION)
                ->timeout(seconds: Config::TIMEOUT)
                ->withToken(token: $this->secretKey, type: 'Bearer')
                ->baseUrl(url: $this->baseUrl)
                ->{$method}($endpoint, $data);

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
        return json_decode($request->body(), false, 512, JSON_THROW_ON_ERROR);
    }

    private function processResponse(object $payload, $request)
    {
        switch ($request->getStatusCode()) {
            case 201:
            case 200:
                return $payload->data ?? $payload;

            case 401:
                throw new UnauthorizedException($payload->message ?? 'Unauthorized, Status Code: ' . $request->getStatusCode());

            case 403:
                throw new ForbiddenException($payload->message ?? 'Forbidden, Status Code: ' . $request->getStatusCode());

            case 404:
                throw new InvalidResourceException($payload->message ?? 'Not Found, Status Code: ' . $request->getStatusCode());

            case 400:
            case 422:
                throw new InvalidPayloadException($payload->message ?? 'Invalid Payload, Status Code: ' . $request->getStatusCode());

            case 406:
                throw new NotAcceptableException($payload->message ?? 'Not Acceptable, Status Code: ' . $request->getStatusCode());

            case 503:
                throw new ServiceUnavailableException($payload->message ?? 'Service Unavailable, Status Code: ' . $request->getStatusCode());

            default:
                throw new ServerErrorException($payload->message ?? 'Server Error, Status Code: ' . $request->getStatusCode());
        }
    }
}
