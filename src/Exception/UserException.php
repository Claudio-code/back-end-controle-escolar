<?php

namespace App\Exception;

use Throwable;
use Exception;

class UserException extends Exception
{
    public function __construct(string $message = '', int $code = 500, Throwable $throwable = null)
    {
        parent::__construct("UserException: {$message}", $code, $throwable);
    }

    public function __toString()
    {
        return __CLASS__ . ": {$this->code}: {$this->message}";
    }
}
