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
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class MessagePipe
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
     * @param string $fallbackErrorMessage // ['Whoops, looks like something went wrong.', 'Server Error', 'Internal Server Error', 'Unknown Status'];
     *
     * @noinspection RedundantDocCommentTagInspection
     */
    public function handle(
        array $structure,
        \Closure $next,
        string $mainTransKey = 'http-statuses',
        string $fallbackErrorMessage = 'Internal Server Error',
        string $fallbackSuccessMessage = 'OK'
    ): JsonResponse {
        $structure['message'] = __($structure['message'] ?: $this->transKeyFor(
            $structure,
            $mainTransKey,
            $fallbackErrorMessage,
            $fallbackSuccessMessage
        ));

        return $next($structure);
    }

    /**
     * @param  array{
     *  status: bool|int|string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: null|array<string, mixed>,
     * }  $structure
     */
    private function transKeyFor(
        array $structure,
        string $mainTransKey,
        string $fallbackErrorMessage,
        string $fallbackSuccessMessage
    ): string {
        $code = $structure['code'];

        if (Lang::has($key = "$mainTransKey.$code")) {
            return $key;
        }

        $statusCode = Utils::statusCodeFor($code);

        if (Lang::has($key = "$mainTransKey.$statusCode")) {
            return $key;
        }

        return Response::$statusTexts[$statusCode] ?? (
            $structure['status'] ? $fallbackSuccessMessage : $fallbackErrorMessage
        );
    }
}
