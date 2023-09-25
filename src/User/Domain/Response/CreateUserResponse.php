<?php

declare(strict_types=1);

namespace App\User\Domain\Response;

use App\User\Domain\Entity\User;

class CreateUserResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $email,
        private readonly string $name,
        private readonly string $createdAt
    ) {
    }

    public static function createFromUser(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getName(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt,
        ];
    }
}