<?php

declare(strict_types=1);

namespace App\Tests\User\Application\CommandHandler;

use App\User\Application\Command\CreateUserCommand;
use App\User\Application\CommandHandler\CreateUserHandler;
use App\User\Application\Factory\CreateUserEntityFactory;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateUserHandlerTest extends TestCase
{
    public function testCreateUserHandlerCreatesUser()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $createUserEntityFactory = $this->createMock(CreateUserEntityFactory::class);

        $id = 1;
        $email = 'email';
        $name = 'name';
        $createdAt = new \DateTime();

        $expectedResult = [
            'id' => $id,
            'email' => $email,
            'name' => $name,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
        ];

        $user = new User();

        $user->setId($id);
        $user->setEmail($email);
        $user->setName($name);
        $user->setCreatedAt($createdAt);

        $createUserCommand = new CreateUserCommand($email, $name);
        $handler = new CreateUserHandler($userRepository, $createUserEntityFactory);

        $createUserEntityFactory->expects($this->once())
            ->method('build')
            ->willReturn($user);

        $userRepository->expects($this->once())
            ->method('save');

        $response = $handler($createUserCommand);

        $this->assertEquals($response->toPrimitives(), $expectedResult);
    }
}
