<?php

declare(strict_types=1);

namespace App\Tests\WorkEntry\Application\CommandHandler;

use App\User\Domain\Entity\User;
use App\WorkEntry\Application\CommandHandler\GetWorkEntryHandler;
use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Application\Query\GetWorkEntryQuery;
use App\WorkEntry\Domain\Entity\WorkEntry;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetWorkEntryHandlerTest extends TestCase
{
    public function testGetWorkEntryHandlerReturnsValidResponse()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);
        $workEntryId = 1;
        $userId = 1;

        $rawStartDate = '2023-09-30 12:34:56';
        $rawEndDate = '2023-09-30 12:34:56';

        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $rawStartDate);
        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $rawEndDate);
        $createdAt = new \DateTime();
        $updatedAt = new \DateTime();

        $expectedResult = [
            'id' => $workEntryId,
            'user_id' => $userId,
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s'),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
        ];

        $user = new User();

        $user->setId($userId);

        $workEntry = new WorkEntry();

        $workEntry->setId($workEntryId);
        $workEntry->setUser($user);
        $workEntry->setStartDate($startDate);
        $workEntry->setEndDate($endDate);
        $workEntry->setCreatedAt($createdAt);
        $workEntry->setUpdatedAt($updatedAt);

        $workEntryRepository->expects($this->once())
            ->method('getById')
            ->with($workEntryId)
            ->willReturn($workEntry);

        $getWorkEntryQuery = new GetWorkEntryQuery($workEntryId);

        $handler = new GetWorkEntryHandler($workEntryRepository);

        $response = $handler($getWorkEntryQuery);

        $this->assertEquals($expectedResult, $response->toPrimitives());
    }
    public function testGetWorkEntryHandlerThrowsExceptionIfWorkEntryNotFound()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);
        $workEntryId = 1;

        $workEntryRepository->expects($this->once())
            ->method('getById')
            ->with($workEntryId)
            ->willReturn(null);

        $getWorkEntryQuery = new GetWorkEntryQuery($workEntryId);
        $handler = new GetWorkEntryHandler($workEntryRepository);

        $this->expectException(WorkEntryNotFoundException::class);

        $handler($getWorkEntryQuery);
    }
}
