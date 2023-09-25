<?php

declare(strict_types=1);

namespace App\WorkEntry\Domain\Response;

use App\WorkEntry\Domain\Entity\WorkEntry;

class CreateWorkEntryResponse
{
    public function __construct(
        private readonly int $id,
        private readonly int $userId,
        private readonly string $startDate,
        private readonly string $createdAt
    ) {
    }

    public static function createFromWorkEntry(WorkEntry $workEntry): self
    {
        return new self(
            $workEntry->getId(),
            $workEntry->getUser()->getId(),
            $workEntry->getStartDate()->format('Y-m-d H:i:s'),
            $workEntry->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'start_date' => $this->startDate,
            'created_at' => $this->createdAt,
        ];
    }
}