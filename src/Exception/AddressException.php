<?php

namespace App\Exception;

use Exception;
use Throwable;

class AddressException extends Exception
{
    public function __construct(string $message = '', int $code = 500, Throwable $throwable = null)
    {
        parent::__construct("AddressException: {$message}", $code, $throwable);
    }

    public function __toString()
    {
        return __CLASS__.": {$this->code}: {$this->message}";
    }
}