<?php

declare(strict_types=1);

namespace App\Tests\User\Application\CommandHandler;

use App\User\Application\CommandHandler\GetUserHandler;
use App\User\Application\Exception\UserNotFoundException;
use App\User\Application\Query\GetUserQuery;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetUserHandlerTest extends TestCase
{
    public function testGetUserHandlerReturnsUser()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userId = 1;
        $userEmail = 'email1';
        $userName = 'name1';
        $userCreatedAt = new \DateTime();
        $userUpdatedAt = new \DateTime();

        $expectedResponse = [
            'id' => $userId,
            'email' => $userEmail,
            'name' => $userName,
            'created_at' => $userCreatedAt->format('Y-m-d H:i:s'),
            'updated_at' => $userUpdatedAt->format('Y-m-d H:i:s'),
        ];

        $user = new User();

        $user->setId($userId);
        $user->setEmail($userEmail);
        $user->setName($userName);
        $user->setCreatedAt($userCreatedAt);
        $user->setUpdatedAt($userUpdatedAt);

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($user);

        $getUserQuery = new GetUserQuery($userId);
        $handler = new GetUserHandler($userRepository);

        $response = $handler($getUserQuery);

        $this->assertEquals($expectedResponse, $response->toPrimitives());
    }

    public function testGetUserHandlerThrowsExceptionIfUserNotFound()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userId = 1;

        $userRepository->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn(null);

        $getUserQuery = new GetUserQuery($userId);
        $handler = new GetUserHandler($userRepository);

        $this->expectException(UserNotFoundException::class);

        $response = $handler($getUserQuery);
    }
}
