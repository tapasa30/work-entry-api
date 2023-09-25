<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Exception;

class WorkEntryActiveException extends \Exception
{
    public function __construct(string $message = 'Another Work Entry is active', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}