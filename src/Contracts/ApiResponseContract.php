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

namespace Guanguans\LaravelApiResponse\Contracts;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ApiResponseContract
{
    /**
     * @param mixed $data
     */
    public function success($data = null, string $message = '', int $code = Response::HTTP_OK): JsonResponse;

    public function error(string $message = '', int $code = Response::HTTP_BAD_REQUEST, ?array $error = null): JsonResponse;

    public function exception(\Throwable $throwable): JsonResponse;

    /**
     * @param int<100, 599>|int<10000, 59999> $code
     * @param mixed $data
     * @param null|array<string, mixed> $error
     */
    public function json(bool $status, int $code, string $message = '', $data = null, ?array $error = null): JsonResponse;
}
