<?php

namespace AxaZara\Moneroo\Exceptions;

use RuntimeException;

class ApiKeyIsMissing extends RunTimeException
{
    public function __construct()
    {
        parent::__construct('API key is missing. Please set it in your .env file. Key name: Moneroo_API_KEY ');
    }
}
