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
use Illuminate\Http\JsonResponse;

class ScalarDataPipe
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
     * }  $structure
     */
    public function handle(array $structure, \Closure $next, ?string $wrap = null): JsonResponse
    {
        $structure['data'] = $this->dataFor($structure['data'], $wrap);

        return $next($structure);
    }

    private function dataFor(mixed $data, ?string $wrap): mixed
    {
        if (!\is_scalar($data) || empty($wrap)) {
            return $data;
        }

        return [$wrap => $data];
    }
}
