<?php

namespace AxaZara\Moneroo;

class Config
{
    public static function validateApiUrl($api_url): void
    {
        if (! filter_var($api_url, FILTER_VALIDATE_URL)) {
            throw new \AxaZara\Moneroo\Exceptions\InvalidApiUrl();
        }
    }

     public static function validateApiKey($api_key): void
     {
         if (empty($api_key)) {
             throw new \AxaZara\Moneroo\Exceptions\ApiKeyIsMissing();
         }
     }
}
