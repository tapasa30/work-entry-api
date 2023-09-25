<?php

declare(strict_types=1);

namespace App\WorkEntry\Domain\Repository;

use App\WorkEntry\Domain\Entity\WorkEntry;

interface WorkEntryRepositoryInterface
{
    public function save(WorkEntry $workEntry): void;

    public function getById(int $id): ?WorkEntry;

    public function getActiveByUserId(int $userId): ?WorkEntry;
}