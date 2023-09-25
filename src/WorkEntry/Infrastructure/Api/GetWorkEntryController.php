<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Api;

use App\WorkEntry\Application\Query\GetWorkEntryQuery;
use App\WorkEntry\Domain\Response\GetWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetWorkEntryController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $getWorkEntryQuery = new GetWorkEntryQuery($id);

        try {
            /** @var GetWorkEntryResponse $getWorkEntryResponse */
            $getWorkEntryResponse = $this->handle($getWorkEntryQuery);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($getWorkEntryResponse->toPrimitives(), Response::HTTP_OK);
    }
}
