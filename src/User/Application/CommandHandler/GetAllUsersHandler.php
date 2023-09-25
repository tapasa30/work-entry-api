<?php

declare(strict_types=1);

namespace App\User\Application\CommandHandler;

use App\User\Application\Query\GetAllUsersQuery;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Response\GetAllUsersResponse;

class GetAllUsersHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(GetAllUsersQuery $getAllUsersCommand): GetAllUsersResponse
    {
        $users = $this->userRepository->findAll();

        return GetAllUsersResponse::createFromUserList($users);
    }
}