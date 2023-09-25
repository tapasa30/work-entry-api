<?php

declare(strict_types=1);

namespace App\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Application\Query\GetUserActiveWorkEntryQuery;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use App\WorkEntry\Domain\Response\GetUserActiveWorkEntryResponse;

class GetUserActiveWorkEntryHandler
{
    public function __construct(private readonly WorkEntryRepositoryInterface $workEntryRepository)
    {
    }

    /**
     * @throws WorkEntryNotFoundException
     */
    public function __invoke(GetUserActiveWorkEntryQuery $getUserActiveWorkEntryQuery): GetUserActiveWorkEntryResponse
    {
        $workEntry = $this->workEntryRepository->getActiveByUserId($getUserActiveWorkEntryQuery->getUserId());

        if ($workEntry === null) {
            throw new WorkEntryNotFoundException();
        }

        return GetUserActiveWorkEntryResponse::createFromWorkEntry($workEntry);
    }
}