<?php

declare(strict_types=1);

namespace App\User\Application\Command;

class CreateUserCommand
{
    public function __construct(private readonly string $email, private readonly string $name)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}