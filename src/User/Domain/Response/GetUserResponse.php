<?php

declare(strict_types=1);

namespace App\User\Domain\Response;

use App\User\Domain\Entity\User;

class GetUserResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $email,
        private readonly string $name,
        private readonly string $createdAt,
        private readonly ?string $updatedAt
    ) {
    }

    public static function createFromUser(User $user): self
    {
        $updatedAt = $user->getUpdatedAt();
        $updatedAtString = null;

        if ($updatedAt !== null) {
            $updatedAtString = $updatedAt->format('Y-m-d H:i:s');
        }

        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getName(),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $updatedAtString,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}