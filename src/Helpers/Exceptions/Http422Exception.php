<?php

namespace App\Helpers\Exceptions;

class Http422Exception extends AppException
{
    public function __construct(string $message, array $errors = [], int $code = 422, \Exception $previous = null)
    {
        parent::__construct($message, $errors, $code, $previous);
    }
}
