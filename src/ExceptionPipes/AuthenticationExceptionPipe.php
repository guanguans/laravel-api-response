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
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationExceptionPipe
{
    use WithPipeArgs;

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
        $structure = $next($throwable);

        if ($throwable instanceof AuthenticationException) {
            return [
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => $throwable->getMessage(),
            ] + $structure;
        }

        return $structure;
    }
}
