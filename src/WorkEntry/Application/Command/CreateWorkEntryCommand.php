<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Command;

class CreateWorkEntryCommand
{
    public function __construct(private readonly int $userId, private readonly string $startDate)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }
}