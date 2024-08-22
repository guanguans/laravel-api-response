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

use Guanguans\LaravelApiResponse\Pipes\Concerns\WithArgs;
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\JsonResponse;

class SetStatusCodePipe
{
    use WithArgs;

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
    public function handle(array $data, \Closure $next, ?int $statusCode = null): JsonResponse
    {
        return $next($data)->setStatusCode($statusCode ?? Utils::statusCodeFor($data['code']));
    }
}
