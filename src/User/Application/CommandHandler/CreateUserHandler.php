<?php

declare(strict_types=1);

namespace App\User\Application\CommandHandler;

use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Factory\CreateUserEntityFactory;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Response\CreateUserResponse;

class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly CreateUserEntityFactory $createUserEntityFactory
    ) {
    }

    public function __invoke(CreateUserCommand $createUserCommand): CreateUserResponse
    {
        $user = $this->createUserEntityFactory->build(
            $createUserCommand->getEmail(),
            $createUserCommand->getName()
        );

        $this->userRepository->save($user);

        return CreateUserResponse::createFromUser($user);
    }
}
