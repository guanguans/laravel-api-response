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

namespace Guanguans\LaravelApiResponse\ExceptionPipes;

use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;
use Guanguans\LaravelApiResponse\Support\Traits\SetStateable;
use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Support\Arr;

class SetErrorExceptionPipe
{
    use MakeStaticable;
    use SetStateable;
    use WithPipeArgs;
    private array $classes;

    /**
     * @param string ...$classes
     */
    public function __construct(
        private readonly ?array $error,
        ...$classes
    ) {
        $this->classes = $classes;
    }

    /**
     * @param \Closure(\Throwable): array $next
     *
     * @return array{
     *     code: int,
     *     message: string,
     *     error: array,
     *     headers: array,
     * }
     *
     * @noinspection RedundantDocCommentTagInspection
     */
    public function handle(\Throwable $throwable, \Closure $next): array
    {
        $structure = $next($throwable);

        if (Arr::first($this->classes, static fn (string $class): bool => $throwable instanceof $class)) {
            return ['error' => $this->error] + $structure;
        }

        return $structure;
    }
}
