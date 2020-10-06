<?php

namespace App\Exception;

use Throwable;
use Exception;

class UserException extends Exception
{
    public function __construct(string $message = '', int $code = 0, Throwable $throwable = null)
    {
        parent::__construct($message, $code, $throwable);
    }

    public function __toString()
    {
        return __CLASS__ . ": {$this->code}: {$this->message}";
    }
}
