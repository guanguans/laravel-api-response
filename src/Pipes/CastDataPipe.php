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

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;
use Guanguans\LaravelApiResponse\Support\Traits\SetStateable;
use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CastDataPipe
{
    use MakeStaticable;
    use SetStateable;
    use WithPipeArgs;
    private string $type;

    /** @var null|list<string> */
    private ?array $only;

    /** @var null|list<string> */
    private ?array $except;

    public function __construct(string $type, ?array $only = null, ?array $except = null)
    {
        $this->type = $type;
        $this->only = $only;
        $this->except = $except;
    }

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
    public function handle(array $structure, \Closure $next): JsonResponse
    {
        if ($this->shouldCast(request())) {
            $structure['data'] = $this->dataFor($structure['data']);
        }

        return $next($structure);
    }

    /**
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::castAttribute()
     * @see https://github.com/TheDragonCode/support/blob/main/src/Concerns/Castable.php
     *
     * @noinspection MultipleReturnStatementsInspection
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function dataFor($data)
    {
        switch ($this->type) {
            case 'null':
                // return (unset) $data;
                /** @noinspection PhpInconsistentReturnPointsInspection */
                return;
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
                throw new InvalidArgumentException("Invalid cast type [$this->type].");
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

    private function shouldCast(Request $request): bool
    {
        if (null === $this->only && null === $this->except) {
            return true;
        }

        if (null !== $this->only && null === $this->except) {
            return $request->is($this->only);
        }

        if (null !== $this->except && null === $this->only) {
            return !$request->is($this->except);
        }

        return $request->is($this->only) && !$request->is($this->except);
    }
}
