<?php

namespace App\Helpers\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AppException extends HttpException
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(string $message, $errors = [], int $code = 400, \Exception $previous = null)
    {
        parent::__construct($code, $message, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
