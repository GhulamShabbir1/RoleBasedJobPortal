<?php

namespace App\Exceptions;

class UnauthorizedException extends AppException
{
    public function __construct(string $message = 'Unauthorized', ?Exception $previous = null)
    {
        parent::__construct($message, 401, 'unauthorized', 0, $previous);
    }
}
