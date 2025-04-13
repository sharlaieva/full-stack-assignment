<?php

declare(strict_types=1);

namespace wnd\appStub\core\response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseFactory
{
    private const string DATA_KEY = 'data';

    public function create(mixed $data, int $code = 200): JsonResponse
    {
        return new JsonResponse(
            [self::DATA_KEY => $data],
            $code,
        );
    }

    public function createError(string $publicMessage, int $code): Response
    {
        return new JsonResponse(
            ['error' => $publicMessage],
            $code,
        );
    }
}
