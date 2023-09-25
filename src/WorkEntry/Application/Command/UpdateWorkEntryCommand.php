<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Command;

class UpdateWorkEntryCommand
{
    public function __construct(
        private readonly int $id,
        private readonly string $endDate
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}