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
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Request;

class JsonResponsableDataPipe
{
    use WithPipeArgs;

    /**
     * @api
     *
     * @param  array{
     *  status: bool,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array<array-key, mixed>,
     * }  $structure
     * @param \Closure(array<string, mixed>): \Illuminate\Http\JsonResponse $next
     *
     * @noinspection RedundantDocCommentTagInspection
     */
    public function handle(array $structure, \Closure $next, bool $assoc = false): JsonResponse
    {
        $structure['data'] = $this->dataFor($structure['data'], $assoc);

        return $next($structure);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::render()
     * @see \Illuminate\Routing\Router::toResponse()
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function dataFor(mixed $data, bool $assoc): mixed
    {
        try {
            return ($response = Router::toResponse(Request::getFacadeRoot(), $data)) instanceof JsonResponse
                ? $response->getData($assoc)
                : $data;
        } catch (\TypeError) {
            return $data;
        } catch (\Throwable $throwable) {
            report($throwable);

            return $data;
        }
    }
}
