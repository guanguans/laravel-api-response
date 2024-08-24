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

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessagePipe
{
    use WithPipeArgs;

    /**
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param string $fallbackMessage // ['Whoops, looks like something went wrong.', 'Server Error', 'Unknown Status']
     * @param  array{
     *  status: string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $data
     */
    public function handle(
        array $data,
        \Closure $next,
        string $mainTransKey = 'http-statuses',
        string $fallbackMessage = 'Server Error'
    ): JsonResponse {
        $data['message'] = __($data['message'] ?: $this->transKeyFor($data['code'], $mainTransKey) ?: $fallbackMessage);

        return $next($data);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::prepareException()
     * @see \Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
     * @see \Symfony\Component\HttpFoundation\Response::setStatusCode()
     */
    private function transKeyFor(int $code, string $mainTransKey): ?string
    {
        /** @var \Illuminate\Translation\Translator $translator */
        $translator = trans();

        if ($translator->has($key = "$mainTransKey.$code")) {
            return $key;
        }

        $statusCode = Utils::statusCodeFor($code);

        if ($translator->has($key = "$mainTransKey.$statusCode")) {
            return $key;
        }

        return Response::$statusTexts[$statusCode] ?? null;
    }
}
