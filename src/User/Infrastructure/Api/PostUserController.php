<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\User\Application\Command\CreateUserCommand;
use App\User\Domain\Response\CreateUserResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class PostUserController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $parameters = \json_decode(
            $request->getContent(),
            true,
            512,
            \JSON_THROW_ON_ERROR
        );

        $createUserCommand = new CreateUserCommand($parameters['email'], $parameters['name']);

        try {
            /** @var CreateUserResponse $createUserResponse */
            $createUserResponse = $this->handle($createUserCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($createUserResponse->toPrimitives(), Response::HTTP_CREATED);
    }
}
