<?php

namespace AxaZara\Moneroo\Exceptions;

use RuntimeException;

class RequestError extends RuntimeException
{
    public function __construct(?string $name)
    {
        parent::__construct("Error occurred while running the API Request: $name");
    }
}
