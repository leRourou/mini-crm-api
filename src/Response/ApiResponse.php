<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $data,
        ];

        return new JsonResponse($response, $statusCode);
    }

    public static function error(
        string $message,
        int $statusCode = 500,
        array $context = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'error' => [
                'message' => $message,
                'code' => $statusCode,
            ],
        ];

        if (!empty($context)) {
            $response['error']['context'] = $context;
        }

        return new JsonResponse($response, $statusCode);
    }

    public static function created(mixed $data = null): JsonResponse
    {
        return self::success($data, 201);
    }

    public static function noContent(): JsonResponse
    {
        return new JsonResponse(null, 204);
    }

    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, 404);
    }

    public static function badRequest(string $message = 'Bad request', array $context = []): JsonResponse
    {
        return self::error($message, 400, $context);
    }

    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, 401);
    }

    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, 403);
    }
}