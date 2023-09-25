<?php

declare(strict_types=1);

namespace App\Tests\User\Application\CommandHandler;

use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\CommandHandler\DeleteUserHandler;
use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DeleteUserHandlerTest extends TestCase
{
    public function testDeleteUserHandlerDeletesUser()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userId = 1;
        $user = new User();

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($user);

        $deleteUserCommand = new DeleteUserCommand($userId);

        $handler = new DeleteUserHandler($userRepository);

        $handler($deleteUserCommand);

        $this->assertNotNull($user->getDeletedAt());
    }

    public function testDeleteUserHandlerThrowsExceptionIfUserNotFound()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userId = 1;

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn(null);

        $deleteUserCommand = new DeleteUserCommand($userId);

        $handler = new DeleteUserHandler($userRepository);

        $this->expectException(UserNotFoundException::class);

        $handler($deleteUserCommand);
    }
}
