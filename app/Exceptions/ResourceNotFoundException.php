<?php

namespace App\Exceptions;

class ResourceNotFoundException extends AppException
{
    public function __construct(string $message = 'Resource not found', ?Exception $previous = null)
    {
        parent::__construct($message, 404, 'notfound', 0, $previous);
    }
}
