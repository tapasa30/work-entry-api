<?php

declare(strict_types=1);

namespace App\WorkEntry\Infrastructure\Api;

use App\WorkEntry\Application\Query\GetUserActiveWorkEntryQuery;
use App\WorkEntry\Domain\Response\GetUserActiveWorkEntryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetUserActiveWorkEntryController extends AbstractController
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

        $getUserCurrentWorkEntryQuery = new GetUserActiveWorkEntryQuery($parameters['user_id']);

        try {
            /** @var GetUserActiveWorkEntryResponse $getUserActiveWorkEntryResponse */
            $getUserActiveWorkEntryResponse = $this->handle($getUserCurrentWorkEntryQuery);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse(['message' => $exception->getPrevious()->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($getUserActiveWorkEntryResponse->toPrimitives(), Response::HTTP_OK);
    }
}
