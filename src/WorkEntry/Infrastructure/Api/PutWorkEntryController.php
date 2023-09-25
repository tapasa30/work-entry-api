<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Api;

use App\WorkEntry\Application\Command\UpdateWorkEntryCommand;
use App\WorkEntry\Domain\Response\UpdateWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class PutWorkEntryController extends AbstractController
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

        $updateWorkEntryCommand = new UpdateWorkEntryCommand($id, $parameters['end_date']);

        try {
            /** @var UpdateWorkEntryResponse $updateWorkEntryResponse */
            $updateWorkEntryResponse = $this->handle($updateWorkEntryCommand);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($updateWorkEntryResponse->toPrimitives(), Response::HTTP_ACCEPTED);
    }
}
