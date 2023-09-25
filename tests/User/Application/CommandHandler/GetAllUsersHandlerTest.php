<?php

declare(strict_types=1);

namespace App\Tests\User\Application\CommandHandler;

use App\User\Application\CommandHandler\GetAllUsersHandler;
use App\User\Application\Query\GetAllUsersQuery;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetAllUsersHandlerTest extends TestCase
{
    public function testGetAllUsersHandlerReturnsAllUsers()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $user1Id = 1;
        $user1Email = 'email1';
        $user1Name = 'name1';
        $user1CreatedAt = new \DateTime();
        $user1UpdatedAt = new \DateTime();

        $user2Id = 2;
        $user2Email = 'email2';
        $user2Name = 'name2';
        $user2CreatedAt = new \DateTime();

        $expectedResponse = [
            [
                'id' => $user1Id,
                'email' => $user1Email,
                'name' => $user1Name,
                'created_at' => $user1CreatedAt->format('Y-m-d H:i:s'),
                'updated_at' => $user1UpdatedAt->format('Y-m-d H:i:s'),
            ],
            [
                'id' => $user2Id,
                'email' => $user2Email,
                'name' => $user2Name,
                'created_at' => $user2CreatedAt->format('Y-m-d H:i:s'),
                'updated_at' => null,
            ]
        ];

        $user1 = new User();
        $user2 = new User();

        $user1->setId($user1Id);
        $user1->setEmail($user1Email);
        $user1->setName($user1Name);
        $user1->setCreatedAt($user1CreatedAt);
        $user1->setUpdatedAt($user1UpdatedAt);

        $user2->setId($user2Id);
        $user2->setEmail($user2Email);
        $user2->setName($user2Name);
        $user2->setCreatedAt($user2CreatedAt);

        $users = [$user1, $user2];

        $userRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $getAllUsersQuery = new GetAllUsersQuery();
        $handler = new GetAllUsersHandler($userRepository);

        $response = $handler($getAllUsersQuery);

        $this->assertEquals($expectedResponse, $response->toPrimitives());
    }
}
