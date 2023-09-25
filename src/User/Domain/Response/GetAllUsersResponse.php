<?php

declare(strict_types=1);

namespace App\User\Domain\Response;

use App\User\Domain\Entity\User;

class GetAllUsersResponse
{
    /**
     * @param array<GetUserResponse> $getUserResponseList
     */
    public function __construct(
        private readonly array $getUserResponseList = []
    ) {
    }

    /**
     * @param array<User> $users
     */
    public static function createFromUserList(array $users): self
    {
        $userResponseList = [];

        foreach ($users as $user) {
            $updatedAt = $user->getUpdatedAt();
            $updatedAtString = null;

            if ($updatedAt !== null) {
                $updatedAtString = $updatedAt->format('Y-m-d H:i:s');
            }

            $userResponseList[] = new GetUserResponse(
                $user->getId(),
                $user->getEmail(),
                $user->getName(),
                $user->getCreatedAt()->format('Y-m-d H:i:s'),
                $updatedAtString,
            );
        }

        return new self($userResponseList);
    }

    public function toPrimitives(): array
    {
        $userList = [];

        foreach ($this->getUserResponseList as $getUserResponse) {
            $userList[] = $getUserResponse->toPrimitives();
        }

        return $userList;
    }
}