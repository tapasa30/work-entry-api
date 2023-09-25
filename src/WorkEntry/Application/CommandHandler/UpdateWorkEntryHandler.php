<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\Command\UpdateWorkEntryCommand;
use App\WorkEntry\Application\Exception\InvalidEndDateException;
use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use App\WorkEntry\Domain\Response\UpdateWorkEntryResponse;

class UpdateWorkEntryHandler
{
    public function __construct(private readonly WorkEntryRepositoryInterface $workEntryRepository)
    {
    }

    /**
     * @throws InvalidEndDateException
     * @throws WorkEntryNotFoundException
     */
    public function __invoke(UpdateWorkEntryCommand $updateWorkEntryCommand): UpdateWorkEntryResponse
    {
        $workEntry = $this->workEntryRepository->getById($updateWorkEntryCommand->getId());

        if ($workEntry === null) {
            throw new WorkEntryNotFoundException();
        }

        $endDate = new \DateTime($updateWorkEntryCommand->getEndDate());

        if ($endDate < $workEntry->getStartDate()) {
            throw new InvalidEndDateException();
        }

        $workEntry->setEndDate($endDate);

        $workEntry->setUpdatedAt(new \DateTime());

        $this->workEntryRepository->save($workEntry);

        return UpdateWorkEntryResponse::createFromWorkEntry($workEntry);
    }
}