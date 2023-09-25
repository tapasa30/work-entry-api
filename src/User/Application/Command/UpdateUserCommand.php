<?php

declare(strict_types=1);

namespace App\User\Application\Command;

class UpdateUserCommand
{
    public function __construct(private readonly int $id, private readonly string $name, private readonly string $email)
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}