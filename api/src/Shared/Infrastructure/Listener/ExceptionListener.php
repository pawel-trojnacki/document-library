<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Application\Exception\RuntimeException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener]
final class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = $this->buildResponse($exception);
        if ($response !== null) {
            $event->setResponse($response);
        }
    }

    private function buildResponse(\Throwable $e): ?JsonResponse
    {
        if ($e instanceof NotFoundHttpException) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatusCode());
        }

        if ($e instanceof AccessDeniedHttpException || $e instanceof AccessDeniedException) {
            return new JsonResponse(['message' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof UnprocessableEntityHttpException && $e->getPrevious() instanceof ValidationFailedException) {
            $e = $e->getPrevious();
        }

        if ($e instanceof ValidationFailedException) {
            $errors = [];

            foreach ($e->getViolations() as $violation) {
                $errors[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return new JsonResponse(
                ['message' => 'Validation failed', 'errors' => $errors],
                RESPONSE::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        if ($e instanceof RuntimeException) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getCode());
        }

        return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        return null;
    }
}
