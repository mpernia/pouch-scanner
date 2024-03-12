<?php

namespace PouchScanner\Domain\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public $errors = [];

    public function __construct(array $errors)
    {
        parent::__construct('The given data failed to pass validation. Errors : ' . json_encode($errors));

        $this->errors = $errors;
    }
}
