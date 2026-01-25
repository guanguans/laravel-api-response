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

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;

class SetMessageExceptionPipe
{
    use WithPipeArgs;

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
    public function handle(\Throwable $throwable, \Closure $next, string $message, string ...$classes): array
    {
        $structure = $next($throwable);

        if (collect($classes)->contains(static fn (string $class): bool => $throwable instanceof $class)) {
            return ['message' => $message] + $structure;
        }

        return $structure;
    }
}
