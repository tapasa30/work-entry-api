<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Command;

class DeleteWorkEntryCommand
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