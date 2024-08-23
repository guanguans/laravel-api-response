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

namespace Guanguans\LaravelApiResponse\ExceptionPipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class HttpExceptionPipe
{
    use WithPipeArgs;

    /**
     * @param \Closure(\Throwable): array $next
     *
     * @return array{
     *     code: int,
     *     message: string,
     *     error: array,
     *     headers: array,
     * }
     */
    public function handle(\Throwable $throwable, \Closure $next): array
    {
        $data = $next($throwable);

        if ($throwable instanceof HttpExceptionInterface) {
            return [
                'message' => $throwable->getMessage(),
                'code' => $throwable->getStatusCode(),
                'headers' => $throwable->getHeaders(),
            ] + $data;
        }

        return $data;
    }
}
