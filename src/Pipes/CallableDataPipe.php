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

class CallableDataPipe
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
    public function handle(array $structure, \Closure $next): JsonResponse
    {
        $structure['data'] = $this->dataFor($structure['data']);

        return $next($structure);
    }

    private function dataFor(mixed $data): mixed
    {
        return \is_callable($data) && !(\is_string($data) && \function_exists($data))
            ? $data()
            : $data;
    }
}
