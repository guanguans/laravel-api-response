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

namespace Guanguans\LaravelApiResponse\Contracts;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ApiResponseContract
{
    public function success(mixed $data = null, string $message = '', int $code = Response::HTTP_OK): JsonResponse;

    public function error(string $message = '', int $code = Response::HTTP_BAD_REQUEST, ?array $error = null): JsonResponse;

    public function exception(\Throwable $throwable): JsonResponse;

    /**
     * @param int<100, 599>|int<100000, 599999> $code
     * @param null|array<string, mixed> $error
     */
    public function json(
        bool|int|string $status,
        int $code,
        string $message = '',
        mixed $data = null,
        ?array $error = null
    ): JsonResponse;
}
