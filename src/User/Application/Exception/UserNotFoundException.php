<?php

declare(strict_types=1);

namespace App\User\Application\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct(string $message = 'User not found', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}