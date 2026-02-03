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

    public function notAcceptable(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_ACCEPTABLE);
    }

    public function proxyAuthenticationRequired(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_PROXY_AUTHENTICATION_REQUIRED);
    }

    public function requestTimeout(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_TIMEOUT);
    }

    public function conflict(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_CONFLICT);
    }

    public function gone(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_GONE);
    }

    public function lengthRequired(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_LENGTH_REQUIRED);
    }

    public function preconditionFailed(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_PRECONDITION_FAILED);
    }

    public function requestEntityTooLarge(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
    }

    public function requestUriTooLong(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_URI_TOO_LONG);
    }

    public function unsupportedMediaType(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
    }

    public function requestedRangeNotSatisfiable(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE);
    }

    public function expectationFailed(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_EXPECTATION_FAILED);
    }

    public function iAmATeapot(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_I_AM_A_TEAPOT);
    }

    public function misdirectedRequest(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_MISDIRECTED_REQUEST);
    }

    public function unprocessableEntity(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function locked(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_LOCKED);
    }

    public function failedDependency(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_FAILED_DEPENDENCY);
    }

    public function tooEarly(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_TOO_EARLY);
    }

    public function upgradeRequired(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UPGRADE_REQUIRED);
    }

    public function preconditionRequired(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_PRECONDITION_REQUIRED);
    }

    public function tooManyRequests(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function requestHeaderFieldsTooLarge(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE);
    }

    public function unavailableForLegalReasons(string $message = ''): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
    }
}
