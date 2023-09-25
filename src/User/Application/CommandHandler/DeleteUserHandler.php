<?php

declare(strict_types=1);

namespace App\User\Application\CommandHandler;

use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepositoryInterface;

class DeleteUserHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(DeleteUserCommand $deleteUserCommand): void
    {
        $user = $this->userRepository->getById($deleteUserCommand->getId());

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $user->setDeletedAt(new \DateTime());

        $this->userRepository->save($user);
    }
}