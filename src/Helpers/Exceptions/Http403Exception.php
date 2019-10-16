<?php

namespace App\Helpers\Exceptions;

class Http403Exception extends AppException
{
    public function __construct(string $message, array $errors = [], int $code = 403, \Exception $previous = null)
    {
        parent::__construct($message, $errors, $code, $previous);
    }
}
