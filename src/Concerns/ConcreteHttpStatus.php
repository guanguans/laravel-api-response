<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Concerns;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @see \Illuminate\Http\Client\Concerns\DeterminesStatusCode
 *
 * @mixin \Guanguans\LaravelApiResponse\ApiResponse
 */
trait ConcreteHttpStatus
{
    public function ok(string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->success(null, $message, $code);
    }

    public function created(mixed $data = null, string $message = '', ?string $location = null): JsonResponse
    {
        return $this->localize($data, $message, Response::HTTP_CREATED, $location);
    }

    public function accepted(mixed $data = null, string $message = '', ?string $location = null): JsonResponse
    {
        return $this->localize($data, $message, Response::HTTP_ACCEPTED, $location);
    }

    public function localize(mixed $data = null, string $message = '', int $code = Response::HTTP_OK, ?string $location = null): JsonResponse
    {
        return tap(
            $this->success($data, $message, $code),
            static function (JsonResponse $jsonResponse) use ($location): void {
                $location and $jsonResponse->header('Location', $location);
            }
        );
    }

    public function noContent(string $message = ''): JsonResponse
    {
        return $this->success(null, $message, Response::HTTP_NO_CONTENT);
    }

    public function badRequest(string $message = ''): JsonResponse
    {
        return $this->error($message);
    }

    public function unauthorized(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAUTHORIZED);
    }

    public function paymentRequired(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_PAYMENT_REQUIRED);
    }

    public function forbidden(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_FORBIDDEN);
    }

    public function notFound(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND);
    }

    public function methodNotAllowed(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function requestTimeout(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_TIMEOUT);
    }

    public function conflict(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_CONFLICT);
    }

    public function teapot(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_I_AM_A_TEAPOT);
    }

    public function unprocessableEntity(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function tooManyRequests(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_TOO_MANY_REQUESTS);
    }
}
