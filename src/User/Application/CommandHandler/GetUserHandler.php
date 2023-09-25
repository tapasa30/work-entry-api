<?php

declare(strict_types=1);

namespace App\User\Application\CommandHandler;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Application\Query\GetUserQuery;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Response\GetUserResponse;

class GetUserHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(GetUserQuery $getUserQuery): GetUserResponse
    {
        $user = $this->userRepository->getById($getUserQuery->getId());

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return GetUserResponse::createFromUser($user);
    }
}