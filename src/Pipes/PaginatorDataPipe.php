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
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

class PaginatorDataPipe
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
     * @see \Illuminate\Http\Resources\Json\ResourceCollection::toResponse()
     * @see \Illuminate\Http\Resources\Json\JsonResource::toResponse()
     * @see \Illuminate\Http\Resources\Json\ResourceResponse::toResponse()
     * @see \Illuminate\Http\Resources\Json\PaginatedResourceResponse::toResponse()
     * @see \Illuminate\Pagination\Paginator::toArray()
     * @see \Illuminate\Pagination\LengthAwarePaginator::toArray()
     * @see \Illuminate\Pagination\CursorPaginator::toArray()
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data)
    {
        return $data instanceof AbstractCursorPaginator || $data instanceof AbstractPaginator
            ? ResourceCollection::make($data)->toResponse(request())->getData()
            : $data;
    }
}
