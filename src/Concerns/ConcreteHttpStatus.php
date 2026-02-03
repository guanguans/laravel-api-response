<?php

/** @noinspection PhpClassHasTooManyDeclaredMembersInspection */

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
    public function ok(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message);
    }

    public function created(mixed $data = null, string $message = '', ?string $location = null): JsonResponse
    {
        return tap(
            $this->success($data, $message, Response::HTTP_CREATED),
            static fn (JsonResponse $jsonResponse): bool => $location and $jsonResponse->header('Location', $location)
        );
    }

    public function accepted(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_ACCEPTED);
    }

    public function nonAuthoritativeInformation(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

    public function noContent(string $message = ''): JsonResponse
    {
        return $this->success(null, $message, Response::HTTP_NO_CONTENT);
    }

    public function resetContent(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_RESET_CONTENT);
    }

    public function partialContent(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_PARTIAL_CONTENT);
    }

    public function multiStatus(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_MULTI_STATUS);
    }

    public function alreadyReported(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_ALREADY_REPORTED);
    }

    public function imUsed(mixed $data = null, string $message = ''): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_IM_USED);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function badRequest(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_BAD_REQUEST, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function unauthorized(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAUTHORIZED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function paymentRequired(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_PAYMENT_REQUIRED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function forbidden(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_FORBIDDEN, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function notFound(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function methodNotAllowed(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_METHOD_NOT_ALLOWED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function notAcceptable(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_ACCEPTABLE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function proxyAuthenticationRequired(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_PROXY_AUTHENTICATION_REQUIRED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function requestTimeout(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_TIMEOUT, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function conflict(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_CONFLICT, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function gone(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_GONE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function lengthRequired(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_LENGTH_REQUIRED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function preconditionFailed(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_PRECONDITION_FAILED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function requestEntityTooLarge(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_ENTITY_TOO_LARGE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function requestUriTooLong(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_URI_TOO_LONG, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function unsupportedMediaType(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNSUPPORTED_MEDIA_TYPE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function requestedRangeNotSatisfiable(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function expectationFailed(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_EXPECTATION_FAILED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function iAmATeapot(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_I_AM_A_TEAPOT, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function misdirectedRequest(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_MISDIRECTED_REQUEST, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function unprocessableEntity(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function locked(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_LOCKED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function failedDependency(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_FAILED_DEPENDENCY, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function tooEarly(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_TOO_EARLY, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function upgradeRequired(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_UPGRADE_REQUIRED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function preconditionRequired(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_PRECONDITION_REQUIRED, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function tooManyRequests(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_TOO_MANY_REQUESTS, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function requestHeaderFieldsTooLarge(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE, $error);
    }

    /**
     * @param null|array<string, mixed> $error
     */
    public function unavailableForLegalReasons(string $message = '', ?array $error = null): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS, $error);
    }
}
