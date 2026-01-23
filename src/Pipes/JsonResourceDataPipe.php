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
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

class JsonResourceDataPipe
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
    public function handle(array $structure, \Closure $next): JsonResponse
    {
        if (
            $structure['data'] instanceof JsonResource
            && !$structure['data']->resource instanceof AbstractCursorPaginator
            && !$structure['data']->resource instanceof AbstractPaginator
        ) {
            JsonResource::withoutWrapping();
            method_exists($structure['data'], 'withoutWrapper') and $structure['data']->withoutWrapper();
        }

        return $next($structure);
    }
}
