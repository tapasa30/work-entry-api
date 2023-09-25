<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Exception;

class WorkEntryNotFoundException extends \Exception
{
    public function __construct(string $message = 'Work Entry not found', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}