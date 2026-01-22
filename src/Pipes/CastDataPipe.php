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

    public function __construct(
        private readonly string $type,
        /** @var null|list<string> */
        private readonly ?array $only = null,
        /** @var null|list<string> */
        private readonly ?array $except = null
    ) {}

    /**
     * @param  array{
     *  status: bool,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $structure
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     *
     * @noinspection RedundantDocCommentTagInspection
     */
    public function handle(array $structure, \Closure $next): JsonResponse
    {
        if ($this->shouldCast(\Illuminate\Support\Facades\Request::getFacadeRoot())) {
            $structure['data'] = $this->dataFor($structure['data']);
        }

        return $next($structure);
    }

    /**
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::castAttribute()
     * @see https://github.com/TheDragonCode/support/blob/main/src/Concerns/Castable.php
     */
    private function dataFor(mixed $data): mixed
    {
        return match ($this->type) {
            // return (unset) $data;
            'null' => null,
            'int', 'integer' => (int) $data,
            'real', 'float', 'double' => $this->fromFloat($data),
            'string' => (string) $data,
            'bool', 'boolean' => (bool) $data,
            'object' => (object) $data,
            'array' => (array) $data,
            default => throw new InvalidArgumentException("Invalid cast type [$this->type]."),
        };
    }

    private function fromFloat(mixed $value): float
    {
        return match ((string) $value) {
            'Infinity' => \INF,
            '-Infinity' => -\INF,
            'NaN' => \NAN,
            default => (float) $value,
        };
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
