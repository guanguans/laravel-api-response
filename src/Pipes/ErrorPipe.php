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

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorPipe
{
    use WithPipeArgs;

    /**
     * @api
     *
     * @param  array{
     *  status: bool|int|string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: null|array<string, mixed>,
     * }  $structure
     * @param \Closure(array<string, mixed>): \Illuminate\Http\JsonResponse $next
     *
     * @noinspection RedundantDocCommentTagInspection
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
     *
     * @param  array{
     *  status: bool|int|string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: null|array<string, mixed>,
     * }  $structure
     *
     * @return array<string, mixed>|\stdClass
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
