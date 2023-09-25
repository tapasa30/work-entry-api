<?php

declare(strict_types=1);

namespace App\User\Application\Factory;

use App\User\Domain\Entity\User;

class CreateUserEntityFactory
{
    public function build(string $email, string $name): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setName($name);
        $user->setCreatedAt(new \DateTime());

        return $user;
    }
}