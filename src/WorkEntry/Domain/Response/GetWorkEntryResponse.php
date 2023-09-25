<?php

declare(strict_types=1);

namespace App\WorkEntry\Domain\Response;

use App\User\Domain\Entity\User;
use App\WorkEntry\Domain\Entity\WorkEntry;

class GetWorkEntryResponse
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
        $endDate = $workEntry->getEndDate();
        $updatedAt = $workEntry->getUpdatedAt();
        $endDateString = null;
        $updatedAtString = null;

        if ($endDate !== null) {
            $endDateString = $endDate->format('Y-m-d H:i:s');
        }

        if ($updatedAt !== null) {
            $updatedAtString = $updatedAt->format('Y-m-d H:i:s');
        }

        return new self(
            $workEntry->getId(),
            $workEntry->getUser()->getId(),
            $workEntry->getStartDate()->format('Y-m-d H:i:s'),
            $endDateString,
            $workEntry->getCreatedAt()->format('Y-m-d H:i:s'),
            $updatedAtString,
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