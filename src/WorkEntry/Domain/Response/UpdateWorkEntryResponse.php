<?php

declare(strict_types=1);

namespace App\WorkEntry\Domain\Response;

use App\WorkEntry\Domain\Entity\WorkEntry;

class UpdateWorkEntryResponse
{
    public function __construct(
        private readonly int $id,
        private readonly int $userId,
        private readonly string $startDate,
        private readonly string $endDate,
        private readonly string $createdAt,
        private readonly string $updatedAt
    ) {
    }

    public static function createFromWorkEntry(WorkEntry $workEntry): self
    {
        return new self(
            $workEntry->getId(),
            $workEntry->getUser()->getId(),
            $workEntry->getStartDate()->format('Y-m-d H:i:s'),
            $workEntry->getEndDate()->format('Y-m-d H:i:s'),
            $workEntry->getCreatedAt()->format('Y-m-d H:i:s'),
            $workEntry->getUpdatedAt()->format('Y-m-d H:i:s'),
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}