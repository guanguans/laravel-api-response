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
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

class PaginatorDataPipe
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
    public function handle(array $structure, \Closure $next, ?string $wrap = null): JsonResponse
    {
        $structure['data'] = $this->dataFor($structure['data'], $wrap);

        return $next($structure);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::render()
     * @see \Illuminate\Http\Resources\Json\ResourceCollection::toResponse()
     * @see \Illuminate\Http\Resources\Json\JsonResource::toResponse()
     * @see \Illuminate\Http\Resources\Json\ResourceResponse::toResponse()
     * @see \Illuminate\Http\Resources\Json\PaginatedResourceResponse::toResponse()
     * @see \Illuminate\Pagination\Paginator::toArray()
     * @see \Illuminate\Pagination\LengthAwarePaginator::toArray()
     * @see \Illuminate\Pagination\CursorPaginator::toArray()
     */
    private function dataFor(mixed $data, ?string $wrap): mixed
    {
        if ($data instanceof AbstractCursorPaginator || $data instanceof AbstractPaginator) {
            $data = ResourceCollection::make($data);
        }

        if (
            !empty($wrap)
            && $data instanceof JsonResource
            && (
                $data->resource instanceof AbstractCursorPaginator
                || $data->resource instanceof AbstractPaginator
            )
        ) {
            $data::wrap($wrap);
            method_exists($data, 'withWrapper') and $data->withWrapper($wrap);
        }

        return $data;
    }
}
