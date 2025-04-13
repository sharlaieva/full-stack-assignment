<?php

declare(strict_types=1);

namespace wnd\appStub\core\response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ResponseExceptionHandler
{
    public function __construct(
        private readonly JsonResponseFactory $responseFactory,
    ) {}

    public function handleException(\Throwable $e): Response
    {
        if ($e instanceof MethodNotAllowedException) {
            return $this->responseFactory->createError(
                'Method not allowed.',
                Response::HTTP_METHOD_NOT_ALLOWED,
            );
        }

        if ($e instanceof ResourceNotFoundException) {
            return $this->responseFactory->createError(
                'No route found.',
                Response::HTTP_NOT_FOUND,
            );
        }

        if ($e instanceof HttpException) {
            $response = $this->responseFactory->createError(
                $e->getMessage(),
                $e->getStatusCode(),
            );
            if (!empty($e->getHeaders())) {
                $response->headers->add($e->getHeaders());
            }
            return $response;
        }

        return $this->responseFactory->createError(
            'Unexpected error.',
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
