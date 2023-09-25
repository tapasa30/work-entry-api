<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Application\Query\GetWorkEntryQuery;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use App\WorkEntry\Domain\Response\GetWorkEntryResponse;

class GetWorkEntryHandler
{
    public function __construct(private readonly WorkEntryRepositoryInterface $workEntryRepository)
    {
    }

    /**
     * @throws WorkEntryNotFoundException
     */
    public function __invoke(GetWorkEntryQuery $getWorkEntryQuery): GetWorkEntryResponse
    {
        $workEntry = $this->workEntryRepository->getById($getWorkEntryQuery->getId());

        if ($workEntry === null) {
            throw new WorkEntryNotFoundException();
        }

        return GetWorkEntryResponse::createFromWorkEntry($workEntry);
    }
}