<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected string $type = 'error';
    protected int $statusCode = 500;

    public function __construct(
        string $message = 'An error occurred',
        int $statusCode = 500,
        string $type = 'error',
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
