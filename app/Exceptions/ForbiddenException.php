<?php

namespace App\Exceptions;

class ForbiddenException extends AppException
{
    public function __construct(string $message = 'Access denied', ?Exception $previous = null)
    {
        parent::__construct($message, 403, 'forbidden', 0, $previous);
    }
}
