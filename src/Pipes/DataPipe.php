<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Pipes\Concerns\WithArgs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Routing\Router;

class DataPipe
{
    use WithArgs;

    /**
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: string,
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
     * @see \Illuminate\Http\Resources\Json\ResourceCollection::toResponse()
     * @see \Illuminate\Http\Resources\Json\JsonResource::toResponse()
     * @see \Illuminate\Http\Resources\Json\ResourceResponse::toResponse()
     * @see \Illuminate\Http\Resources\Json\PaginatedResourceResponse::toResponse()
     * @see \Illuminate\Pagination\Paginator::toArray()
     * @see \Illuminate\Pagination\LengthAwarePaginator::toArray()
     * @see \Illuminate\Pagination\CursorPaginator::toArray()
     * @see \Illuminate\Http\JsonResponse::setData()
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data)
    {
        if ($data instanceof AbstractCursorPaginator || $data instanceof AbstractPaginator) {
            return ResourceCollection::make($data)->toResponse(request())->getData();
        }

        if (($response = Router::toResponse(request(), $data)) instanceof JsonResponse) {
            return $response->getData();
        }

        !\is_array($data) and !\is_object($data) and $data = (object) $data;

        return $data;
    }
}
