<?php

declare(strict_types=1);

namespace App\User\Application\Query;

class GetUserQuery
{
    public function __construct(private readonly int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}