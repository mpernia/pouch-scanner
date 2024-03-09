<?php

namespace PouchScanner\Domain\Exceptions;

use Exception;

class InvalidResponseException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
