<?php

declare(strict_types=1);

namespace App\User\Application\CommandHandler;

use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Response\UpdateUserResponse;

class UpdateUserHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(UpdateUserCommand $updateUserCommand): UpdateUserResponse
    {
        $user = $this->userRepository->getById($updateUserCommand->getId());

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $user->setName($updateUserCommand->getName());
        $user->setEmail($updateUserCommand->getEmail());
        $user->setUpdatedAt(new \DateTime());

        $this->userRepository->save($user);

        return UpdateUserResponse::createFromUser($user);
    }
}