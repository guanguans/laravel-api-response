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
use Illuminate\Support\Arr;

class SetMessageExceptionPipe
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
    public function handle(\Throwable $throwable, \Closure $next, string $message, string ...$exceptionClasses): array
    {
        $data = $next($throwable);

        if (Arr::first($exceptionClasses, static fn (string $class): bool => $throwable instanceof $class)) {
            return ['message' => $message] + $data;
        }

        return $data;
    }
}
