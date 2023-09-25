<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\User\Application\Query\GetAllUsersQuery;
use App\User\Domain\Response\GetAllUsersResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetAllUsersController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getAllUserCommand = new GetAllUsersQuery();

        /** @var GetAllUsersResponse $users */
        $users = $this->handle($getAllUserCommand);

        return new JsonResponse($users->toPrimitives(), Response::HTTP_OK);
    }
}
