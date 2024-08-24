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

class StatusCodePipe
{
    use WithPipeArgs;

    /**
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $data
     */
    public function handle(array $data, \Closure $next, int $fallbackStatusCode = 500): JsonResponse
    {
        $statusCode = Utils::statusCodeFor($data['code']);

        return $next($data)->setStatusCode($this->IsInvalidStatusCode($statusCode) ? $fallbackStatusCode : $statusCode);
    }

    /**
     * @see \Symfony\Component\HttpFoundation\Response::isInvalid()
     */
    private function IsInvalidStatusCode(int $statusCode): bool
    {
        return 100 > $statusCode || 600 <= $statusCode;
    }
}
