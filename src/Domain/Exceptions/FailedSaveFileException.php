<?php

namespace PouchScanner\Domain\Exceptions;

use Exception;

class FailedSaveFileException extends Exception
{
    public function __construct(string $filename)
    {
        parent::__construct('Failed to save file to disk: ' . $filename);
    }
}
