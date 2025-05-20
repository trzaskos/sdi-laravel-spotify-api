<?php

namespace App\Exceptions;

use Exception;

class MusicApiException extends Exception
{
    public function __construct(
        string $message = 'Music service error',
        int $code = 500
    ) {
        parent::__construct($message, $code);
    }
}
