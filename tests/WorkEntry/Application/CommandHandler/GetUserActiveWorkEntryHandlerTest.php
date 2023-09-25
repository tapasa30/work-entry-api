<?php

declare(strict_types=1);

namespace App\Tests\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\CommandHandler\GetUserActiveWorkEntryHandler;
use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Application\Query\GetUserActiveWorkEntryQuery;
use App\WorkEntry\Domain\Entity\WorkEntry;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetUserActiveWorkEntryHandlerTest extends TestCase
{
    public function testGetUserActiveWorkEntryHandlerReturnsValidResponse()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);

        $userId = 1;
        $startDate = new \DateTime();
        $createdAt = new \DateTime();

        $expectedResult = [
            'id' => 1,
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => null,
        ];

        $workEntry = new WorkEntry();

        $workEntry->setId(1);
        $workEntry->setStartDate($startDate);
        $workEntry->setCreatedAt($createdAt);

        $workEntryRepository->expects($this->once())
            ->method('getActiveByUserId')
            ->with($userId)
            ->willReturn($workEntry);

        $getUserActiveWorkEntryQuery = new GetUserActiveWorkEntryQuery($userId);
        $handler = new GetUserActiveWorkEntryHandler($workEntryRepository);

        $response = $handler($getUserActiveWorkEntryQuery);

        $this->assertEquals($expectedResult, $response->toPrimitives());
    }

    public function testGetUserActiveWorkEntryHandlerThrowsExceptionIfWorkEntryNotFound()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);

        $userId = 1;

        $workEntryRepository->expects($this->once())
            ->method('getActiveByUserId')
            ->with($userId)
            ->willReturn(null);

        $getUserActiveWorkEntryQuery = new GetUserActiveWorkEntryQuery($userId);
        $handler = new GetUserActiveWorkEntryHandler($workEntryRepository);

        $this->expectException(WorkEntryNotFoundException::class);

        $handler($getUserActiveWorkEntryQuery);
    }
}
