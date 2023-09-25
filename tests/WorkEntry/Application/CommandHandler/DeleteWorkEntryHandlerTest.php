<?php

declare(strict_types=1);

namespace App\Tests\WorkEntry\Application\CommandHandler;

use App\WorkEntry\Application\Command\DeleteWorkEntryCommand;
use App\WorkEntry\Application\CommandHandler\DeleteWorkEntryHandler;
use App\WorkEntry\Application\Exception\WorkEntryNotFoundException;
use App\WorkEntry\Domain\Entity\WorkEntry;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DeleteWorkEntryHandlerTest extends TestCase
{
    public function testDeleteWorkEntryHandlerSoftDeletesWorkEntry()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);

        $workEntryId = 1;

        $workEntry = new WorkEntry();

        $workEntry->setId($workEntryId);

        $workEntryRepository->expects($this->once())
            ->method('getById')
            ->with($workEntryId)
            ->willReturn($workEntry);

        $deleteWorkEntryCommand = new DeleteWorkEntryCommand($workEntryId);

        $handler = new DeleteWorkEntryHandler($workEntryRepository);

        $handler($deleteWorkEntryCommand);

        $this->assertNotNull($workEntry->getDeletedAt());
    }

    public function testDeleteWorkEntryHandlerThrowsExceptionIfWorkEntryNotFound()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);

        $workEntryId = 1;

        $workEntryRepository->expects($this->once())
            ->method('getById')
            ->with($workEntryId)
            ->willReturn(null);

        $deleteWorkEntryCommand = new DeleteWorkEntryCommand($workEntryId);

        $handler = new DeleteWorkEntryHandler($workEntryRepository);

        $this->expectException(WorkEntryNotFoundException::class);

        $handler($deleteWorkEntryCommand);
    }
}
