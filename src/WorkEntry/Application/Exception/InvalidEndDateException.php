<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Exception;

class InvalidEndDateException extends \Exception
{
    public function __construct(string $message = 'Invalid End Date', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}