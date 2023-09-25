<?php

declare(strict_types=1);

namespace App\User\Application\Command;

class DeleteUserCommand
{
    public function __construct(private readonly int $id)
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}