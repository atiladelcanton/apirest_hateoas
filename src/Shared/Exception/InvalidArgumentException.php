<?php

namespace App\Shared\Exception;

use Exception;

class InvalidArgumentException extends Exception
{
    private $fields;

    public function __construct($message, $code = 0, Throwable $previous = null, $fields = [])
    {
        parent::__construct($message, $code, $previous);
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }
}