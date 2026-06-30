<?php

namespace App\Exceptions;

class ValidationFailedException extends AppException
{
    public function __construct(string $message = 'Validation failed', ?Exception $previous = null)
    {
        parent::__construct($message, 422, 'validation', 0, $previous);
    }
}
