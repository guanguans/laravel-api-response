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

use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;
use Guanguans\LaravelApiResponse\Support\Traits\SetStateable;
use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Support\Arr;

class SetHeadersExceptionPipe
{
    use WithPipeArgs;
    use MakeStaticable;
    use SetStateable;
    private array $headers;
    private array $classes;

    /**
     * @param string ...$classes
     */
    public function __construct(array $headers, ...$classes)
    {
        $this->headers = $headers;
        $this->classes = $classes;
    }

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
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

        if (Arr::first($this->classes, static fn (string $class): bool => $throwable instanceof $class)) {
            return ['headers' => $this->headers] + $data;
        }

        return $data;
    }
}