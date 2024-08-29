<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StatusCodePipe
{
    use WithPipeArgs;

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $data
     */
    public function handle(array $data, \Closure $next, int $fallbackStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $next($data)->setStatusCode($this->statusCodeFor($data['code'], $fallbackStatusCode));
    }

    private function statusCodeFor(int $code, int $fallbackStatusCode): int
    {
        return $this->isInvalidStatusCode($statusCode = Utils::statusCodeFor($code))
            ? $fallbackStatusCode
            : $statusCode;
    }

    /**
     * @see \Symfony\Component\HttpFoundation\Response::isInvalid()
     */
    private function isInvalidStatusCode(int $statusCode): bool
    {
        return Response::HTTP_CONTINUE > $statusCode || 600 <= $statusCode;
    }
}
