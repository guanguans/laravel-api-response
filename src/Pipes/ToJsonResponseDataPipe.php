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
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;

class ToJsonResponseDataPipe
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
     * }  $data
     */
    public function handle(array $data, \Closure $next): JsonResponse
    {
        $data['data'] = $this->dataFor($data['data']);

        return $next($data);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::render()
     * @see \Illuminate\Routing\Router::toResponse()
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     * @noinspection BadExceptionsProcessingInspection
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data)
    {
        try {
            return ($response = Router::toResponse(request(), $data)) instanceof JsonResponse
                ? $response->getData()
                : $data;
        } catch (\TypeError $typeError) {
            return $data;
        } catch (\Throwable $throwable) { // @codeCoverageIgnoreStart
            report($throwable);

            return $data; // @codeCoverageIgnoreEnd
        }
    }
}
