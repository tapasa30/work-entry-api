<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\User\Application\Command\UpdateUserCommand;
use App\User\Domain\Response\UpdateUserResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class PutUserController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $parameters = \json_decode(
            $request->getContent(),
            true,
            512,
            \JSON_THROW_ON_ERROR
        );

        $updateUserCommand = new UpdateUserCommand($id, $parameters['name'], $parameters['email']);

        try {
            /** @var UpdateUserResponse $updatedUserResponse */
            $updatedUserResponse = $this->handle($updateUserCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($updatedUserResponse->toPrimitives(), Response::HTTP_ACCEPTED);
    }
}
