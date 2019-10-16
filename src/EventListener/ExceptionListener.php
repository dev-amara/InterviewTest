<?php

namespace App\EventListener;

use App\Helpers\Exceptions\Http400Exception;
use App\Helpers\Exceptions\Http403Exception;
use App\Helpers\Exceptions\Http422Exception;
use App\Helpers\Exceptions\HttpException;
use App\Helpers\Exceptions\ValidationException;
use App\Helpers\Utils\AbstractController;
use App\Helpers\Utils\JsonView;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Exception;
use App\Helpers\Exceptions\AppException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if ($exception instanceof ValidationException) {
            $response = $this->handleValidationExceptions($exception);
        } elseif ($exception instanceof NotFoundHttpException) {
            $response = $this->handleNotFoundHttpExceptions($exception);
        } elseif ($exception instanceof Http422Exception) {
            $response = $this->handleHttp422Exceptions($exception);
        } elseif ($exception instanceof Http403Exception) {
            $response = $this->handleHttp403Exceptions($exception);
        } elseif ($exception instanceof Http400Exception) {
            $response = $this->handleHttp400Exceptions($exception);
        } elseif ($exception instanceof HttpException) {
            $response = $this->handleHttpExceptions($exception);
        } elseif ($exception instanceof AppException) {
            $response = $this->handleAppExceptions($exception);
        } elseif ($exception instanceof ORMException) {
            $response = $this->handleORMException($exception);
        } elseif ($exception instanceof UniqueConstraintViolationException) {
            $response = $this->handleUniqueConstraintViolationException($exception);
        } else {
            $response = $this->handleUnknownExceptions($event->getException());
        }

        $event->setResponse($response);
    }

    private function handleValidationExceptions(ValidationException $exception)
    {
        $header = ['Content-Type' => AbstractController::CONTENT_TYPE];

        $response = new JsonView(
            null,
            "Une erreur est survenue lors de l'enregistrement.",
            Response::HTTP_UNPROCESSABLE_ENTITY,
            json_decode($exception->getMessage(), 1)['errors']
        );

        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY, $header);
    }

    private function handleAppExceptions(AppException $exception): Response
    {
        return $this->handleKnownExceptions($exception, 400);
    }

    private function handleHttpExceptions(HttpException $exception): Response
    {

        return $this->handleKnownExceptions($exception, 400);
    }

    private function handleNotFoundHttpExceptions(NotFoundHttpException $exception): Response
    {
        return $this->handleKnownExceptions($exception, 404);
    }

    private function handleHttp422Exceptions(Http422Exception $exception): Response
    {

        return $this->handleKnownExceptions($exception, 422, $exception->getErrors());
    }

    private function handleHttp400Exceptions(Http400Exception $exception): Response
    {

        return $this->handleKnownExceptions($exception, 400, $exception->getErrors());
    }

    private function handleUniqueConstraintViolationException(UniqueConstraintViolationException $exception): Response
    {
        return $this->handleKnownExceptions($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function handleORMException(ORMException $exception): Response
    {
        return $this->handleKnownExceptions($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function handleKnownExceptions(
        Exception $exception,
        $code,
        $errors = [],
        $meta = [],
        $statusCode = null
    ): Response {
        $header = [];
        if (Response::HTTP_BAD_REQUEST === $code) {
            $header = ['Content-Type' => AbstractController::CONTENT_TYPE];
        } else {
            $this->logger->error($exception);
        }
        $response = new JsonView(null, $exception->getMessage(), $code, $errors, $meta, $statusCode);

        return new JsonResponse($response, $code, $header);
    }

    private function handleUnknownExceptions(Exception $exception): Response
    {
        $this->logger->error($exception);

        $response = new JsonView(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, []);

        return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function handleHttp403Exceptions($exception)
    {
        return $this->handleKnownExceptions($exception, 403, $exception->getErrors(), [], 'UNAUTHORIZED_OCA_USER');
    }
}
