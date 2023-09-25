<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Api;

use App\WorkEntry\Domain\Response\CreateWorkEntryResponse;
use App\WorkEntry\Application\Command\CreateWorkEntryCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class PostWorkEntryController extends AbstractController
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

        $createWorkEntryCommand = new CreateWorkEntryCommand($parameters['user_id'], $parameters['start_date']);

        try {
            /** @var CreateWorkEntryResponse $createWorkEntryResponse */
            $createWorkEntryResponse = $this->handle($createWorkEntryCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($createWorkEntryResponse->toPrimitives(), Response::HTTP_CREATED);
    }
}
