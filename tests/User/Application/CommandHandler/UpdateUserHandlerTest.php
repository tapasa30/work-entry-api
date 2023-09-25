<?php

declare(strict_types=1);

namespace App\Tests\User\Application\CommandHandler;

use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\CommandHandler\UpdateUserHandler;
use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UpdateUserHandlerTest extends TestCase
{
    public function testUpdateUserHandlerUpdatesUser()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $newName = 'nawNAme';
        $newEmail = 'new@email.com';

        $userId = 1;
        $userCreatedAt = new \DateTime();
        $userUpdatedAt = new \DateTime();

        $expectedResponse = [
            'id' => $userId,
            'email' => $newEmail,
            'name' => $newName,
            'created_at' => $userCreatedAt->format('Y-m-d H:i:s'),
            'updated_at' => $userUpdatedAt->format('Y-m-d H:i:s'),
        ];

        $user = new User();

        $user->setId($userId);
        $user->setCreatedAt($userCreatedAt);
        $user->setUpdatedAt($userUpdatedAt);

        $updateUserCommand = new UpdateUserCommand($userId, $newName, $newEmail);

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($user);

        $handler = new UpdateUserHandler($userRepository);

        $userRepository->expects($this->once())
            ->method('save');

        $response = $handler($updateUserCommand);

        $this->assertEquals($expectedResponse, $response->toPrimitives());
    }

    public function testUpdateUserHandlerThrowsExceptionIfUserNotFound()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $newName = 'nawNAme';
        $newEmail = 'new@email.com';

        $userId = 1;

        $updateUserCommand = new UpdateUserCommand($userId, $newName, $newEmail);

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn(null);

        $handler = new UpdateUserHandler($userRepository);

        $this->expectException(UserNotFoundException::class);

        $userRepository->expects($this->never())
            ->method('save');

        $handler($updateUserCommand);
    }
}
