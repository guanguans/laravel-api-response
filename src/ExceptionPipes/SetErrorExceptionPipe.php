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

    /** @var list<class-string<\Throwable>> */
    private array $classes;

    /**
     * @param null|array<string, mixed> $error
     * @param class-string<\Throwable> ...$classes
     */
    public function __construct(
        private readonly ?array $error,
        /** @see self::__set_state() */
        mixed ...$classes
    ) {
        $this->classes = $classes;
    }

    /**
     * @api
     *
     * @param \Closure(\Throwable): array<string, mixed> $next
     *
     * @return array{
     *     code: int,
     *     message: string,
     *     error: array<string, mixed>,
     *     headers: array<string, null|list<null|string>|string>,
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
