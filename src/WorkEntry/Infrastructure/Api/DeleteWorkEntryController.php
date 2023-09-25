<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Api;

use App\WorkEntry\Application\Command\DeleteWorkEntryCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteWorkEntryController extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $deleteWorkEntryCommand = new DeleteWorkEntryCommand($id);

        try {
            $this->messageBus->dispatch($deleteWorkEntryCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_ACCEPTED);
    }
}
