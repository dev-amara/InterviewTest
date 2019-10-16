<?php

namespace App\Helpers\Exceptions;

class Http400Exception extends AppException
{
    public function __construct(string $message, array $errors = [], int $code = 400, \Exception $previous = null)
    {
        parent::__construct($message, $errors, $code, $previous);
    }
}
