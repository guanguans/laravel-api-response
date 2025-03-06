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
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class MessagePipe
{
    use WithPipeArgs;

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param string $fallbackErrorMessage // ['Whoops, looks like something went wrong.', 'Server Error', 'Internal Server Error', 'Unknown Status'];
     * @param  array{
     *  status: bool,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $structure
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
