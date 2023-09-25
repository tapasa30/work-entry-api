<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\Command\DeleteWorkEntryCommand;
use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;

class DeleteWorkEntryHandler
{
    public function __construct(private readonly WorkEntryRepositoryInterface $workEntryRepository)
    {
    }

    /**
     * @throws WorkEntryNotFoundException
     */
    public function __invoke(DeleteWorkEntryCommand $deleteWorkEntryCommand): void
    {
        $workEntry = $this->workEntryRepository->getById($deleteWorkEntryCommand->getId());

        if ($workEntry === null) {
            throw new WorkEntryNotFoundException();
        }

        $workEntry->setDeletedAt(new \DateTime());

        $this->workEntryRepository->save($workEntry);
    }
}