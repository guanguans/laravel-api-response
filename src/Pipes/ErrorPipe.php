<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Pipes\Concerns\WithArgs;
use Illuminate\Http\JsonResponse;

class ErrorPipe
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
    public function handle(array $data, \Closure $next, bool $hidden = false): JsonResponse
    {
        if ($hidden) {
            unset($data['error']);
        } else {
            $data['error'] = $data['error'] ?: (object) [];
        }

        return $next($data);
    }
}
