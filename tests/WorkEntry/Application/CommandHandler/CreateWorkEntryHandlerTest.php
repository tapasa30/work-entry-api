<?php

declare(strict_types=1);

namespace App\Tests\WorkEntry\Application\CommandHandler;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\WorkEntry\Application\Command\CreateWorkEntryCommand;
use App\WorkEntry\Application\CommandHandler\CreateWorkEntryHandler;
use App\WorkEntry\Application\Factory\CreateWorkEntryEntityFactory;
use App\WorkEntry\Domain\Entity\WorkEntry;
use App\WorkEntry\Domain\Repository\WorkEntryRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateWorkEntryHandlerTest extends TestCase
{
    public function testCreateWorkEntryHandlerCreatesWorkEntry()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);
        $createWorkEntryEntityFactory = $this->createMock(CreateWorkEntryEntityFactory::class);
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userId = 1;
        $rawStartDate = '2023-09-30 12:34:56';
        $startDate = new \DateTime($rawStartDate);

        $user = new User();

        $user->setId($userId);

        $workEntry = new WorkEntry();

        $workEntry->setId(1);
        $workEntry->setUser($user);
        $workEntry->setCreatedAt(new \DateTime());
        $workEntry->setStartDate($startDate);

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($user);

        $createWorkEntryCommand = new CreateWorkEntryCommand($userId, $rawStartDate);

        $handler = new CreateWorkEntryHandler($workEntryRepository, $userRepository, $createWorkEntryEntityFactory);

        $workEntryRepository->expects($this->once())
            ->method('getActiveByUserId')
            ->with($userId)
            ->willReturn(null);

        $createWorkEntryEntityFactory->expects($this->once())
            ->method('build')
            ->with($user, $startDate)
            ->willReturn($workEntry);

        $workEntryRepository->expects($this->once())
            ->method('save');

        $handler($createWorkEntryCommand);
    }
    public function testCreateWorkEntryHandlerThrowsExceptionIfUserNotFound()
    {
        $workEntryRepository = $this->createMock(WorkEntryRepositoryInterface::class);
        $createWorkEntryEntityFactory = $this->createMock(CreateWorkEntryEntityFactory::class);
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $rawStartDate = '2023-09-30 12:34:56';

        $createWorkEntryCommand = new CreateWorkEntryCommand(1, $rawStartDate);
        $handler = new CreateWorkEntryHandler($workEntryRepository, $userRepository, $createWorkEntryEntityFactory);

        $userRepository->expects($this->once())
            ->method('getById')
            ->willReturn(null);

        $workEntryRepository->expects($this->never())
            ->method('getActiveByUserId');

        $createWorkEntryEntityFactory->expects($this->never())
            ->method('build');

        $workEntryRepository->expects($this->never())
            ->method('save');

        $this->expectException(UserNotFoundException::class);

        $handler($createWorkEntryCommand);
    }
}
