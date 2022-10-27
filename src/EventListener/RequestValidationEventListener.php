<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\EventListener;

use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class RequestValidationEventListener
{
    public function __construct(private int $responseCode = Response::HTTP_BAD_REQUEST) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = null;

        if ($exception instanceof RequestValidationException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage(), 'errors' => $exception->getResponseErrors()],
                $this->responseCode,
            );
        }

        if ($response !== null) {
            $event->setResponse($response);
        }
    }
}
