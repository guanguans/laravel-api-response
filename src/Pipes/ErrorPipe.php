<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorPipe
{
    use WithPipeArgs;

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: bool,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $structure
     */
    public function handle(array $structure, \Closure $next, bool $hidden = false): JsonResponse
    {
        $structure['error'] = $this->errorFor($structure);

        if ($hidden) {
            unset($structure['error']);
        }

        return $next($structure);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
     */
    private function errorFor(array $structure): array|\stdClass
    {
        $error = (array) $structure['error'];

        if ([] === $error) {
            return (object) $error;
        }

        if (
            $structure['message']
            && isset($error['message'])
            && \in_array(
                $error['message'],
                ['', 'Server Error', Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]],
                true
            )
        ) {
            $error['message'] = $structure['message'];
        }

        return $error;
    }
}
