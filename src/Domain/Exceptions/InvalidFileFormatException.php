<?php

namespace PouchScanner\Domain\Exceptions;

use Exception;

class InvalidFileFormatException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid XML format. Unprocessed content.');
    }
}
