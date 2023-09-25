<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\User\Application\Query\GetUserQuery;
use App\User\Domain\Response\GetUserResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetUserController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $getUserCommand = new GetUserQuery($id);

        try {
            /** @var GetUserResponse $user */
            $user = $this->handle($getUserCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user->toPrimitives(), Response::HTTP_OK);
    }
}
