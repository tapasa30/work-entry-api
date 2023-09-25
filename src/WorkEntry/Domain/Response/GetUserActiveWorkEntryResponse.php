<?php

declare(strict_types=1);

namespace App\WorkEntry\Domain\Response;

use App\WorkEntry\Domain\Entity\WorkEntry;

class GetUserActiveWorkEntryResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $startDate,
        private readonly string $createdAt,
        private readonly ?string $updatedAt
    ) {
    }

    public static function createFromWorkEntry(WorkEntry $workEntry): self
    {
        $updatedAt = $workEntry->getUpdatedAt();
        $updatedAtString = null;

        if ($updatedAt !== null) {
            $updatedAtString = $updatedAt->format('Y-m-d H:i:s');
        }

        return new self(
            $workEntry->getId(),
            $workEntry->getStartDate()->format('Y-m-d H:i:s'),
            $workEntry->getCreatedAt()->format('Y-m-d H:i:s'),
            $updatedAtString,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->startDate,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}