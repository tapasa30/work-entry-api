<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\CommandHandler;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\WorkEntry\Application\Exception\WorkEntryActiveException;
use App\WorkEntry\Application\Factory\CreateWorkEntryEntityFactory;
use App\WorkEntry\Domain\Response\CreateWorkEntryResponse;
use App\WorkEntry\Application\Command\CreateWorkEntryCommand;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;

class CreateWorkEntryHandler
{
    public function __construct(
        private readonly WorkEntryRepositoryInterface $workEntryRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly CreateWorkEntryEntityFactory $createWorkEntryEntityFactory
    ) {
    }

    public function __invoke(CreateWorkEntryCommand $createWorkEntryCommand): CreateWorkEntryResponse
    {
        $userId = $createWorkEntryCommand->getUserId();

        $user = $this->userRepository->getById($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $activeWorkEntry = $this->workEntryRepository->getActiveByUserId($userId);

        if ($activeWorkEntry !== null) {
            throw new WorkEntryActiveException();
        }

        $startDate = new \DateTime($createWorkEntryCommand->getStartDate());

        $workEntry = $this->createWorkEntryEntityFactory->build(
            $user,
            $startDate
        );

        $this->workEntryRepository->save($workEntry);

        return CreateWorkEntryResponse::createFromWorkEntry($workEntry);
    }
}