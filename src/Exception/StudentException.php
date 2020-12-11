<?php

namespace App\Exception;

use Exception;
use Throwable;

class StudentException extends Exception
{
    public function __construct(string $message = '', int $code = 500, Throwable $throwable = null)
    {
        parent::__construct("Estudante: {$message}", $code, $throwable);
    }

    public function __toString()
    {
        return __CLASS__.": {$this->code}: {$this->message}";
    }
}