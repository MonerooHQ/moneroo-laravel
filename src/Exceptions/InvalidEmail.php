<?php

namespace AxaZara\Moneroo\Exceptions;

use RuntimeException;

class InvalidEmail extends RunTimeException
{
    public function __construct()
    {
        parent::__construct('Email is invalid. Please check your email address.');
    }
}
