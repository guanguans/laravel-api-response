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

class CastDataPipe
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
    public function handle(array $structure, \Closure $next, string $type): JsonResponse
    {
        $structure['data'] = $this->dataFor($structure['data'], $type);

        return $next($structure);
    }

    /**
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::castAttribute()
     *
     * @noinspection MultipleReturnStatementsInspection
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data, string $type)
    {
        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $data;
            case 'real':
            case 'float':
            case 'double':
                return $this->fromFloat($data);
            case 'string':
                return (string) $data;
            case 'bool':
            case 'boolean':
                return (bool) $data;
            case 'object':
                return (object) $data;
            case 'array':
                return (array) $data;
            default:
                throw new \InvalidArgumentException("Invalid cast type [$type].");
        }
    }

    /**
     * @param mixed $value
     */
    private function fromFloat($value): float
    {
        switch ((string) $value) {
            case 'Infinity':
                return \INF;
            case '-Infinity':
                return -\INF;
            case 'NaN':
                return \NAN;
            default:
                return (float) $value;
        }
    }
}
