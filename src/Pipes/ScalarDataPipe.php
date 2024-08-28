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

class ScalarDataPipe
{
    use WithPipeArgs;

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: string,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $data
     */
    public function handle(array $data, \Closure $next, bool $assoc = false, ?string $wrap = null): JsonResponse
    {
        $data['data'] = $this->dataFor($data['data'], $assoc, $wrap);

        return $next($data);
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data, bool $assoc, ?string $wrap)
    {
        if (!\is_scalar($data)) {
            return $data;
        }

        if ($assoc) {
            return (array) $data;
        }

        return $wrap ? [$wrap => $data] : (object) $data;
    }
}
