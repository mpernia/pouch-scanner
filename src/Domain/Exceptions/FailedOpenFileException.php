<?php

namespace PouchScanner\Domain\Exceptions;

use Exception;

class FailedOpenFileException extends Exception
{
    public function __construct(string $filename)
    {
        parent::__construct('Failed to open file to disk: ' . $filename);
    }
}
