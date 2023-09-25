<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\Query;

class GetUserActiveWorkEntryQuery
{
    public function __construct(private readonly int $userId)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}