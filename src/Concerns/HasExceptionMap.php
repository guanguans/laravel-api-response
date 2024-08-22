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

namespace Guanguans\LaravelApiResponse\Concerns;

use Illuminate\Support\Collection;

/**
 * @mixin \Guanguans\LaravelApiResponse\ApiResponse
 */
trait HasExceptionMap
{
    private Collection $exceptionMap;

    /**
     * @param class-string|class-string<\Throwable> $exception
     * @param array|callable(\Throwable): (array|\Throwable)|\Throwable $mapper
     */
    public function prependExceptionMap(string $exception, $mapper): self
    {
        return $this->tapExceptionMap(static function (Collection $exceptionMap) use ($mapper, $exception): void {
            $exceptionMap->prepend($mapper, $exception);
        });
    }

    /**
     * @param class-string|class-string<\Throwable> $exception
     * @param array|callable(\Throwable): (array|\Throwable)|\Throwable $mapper
     */
    public function putExceptionMap(string $exception, $mapper): self
    {
        return $this->tapExceptionMap(static function (Collection $exceptionMap) use ($exception, $mapper): void {
            $exceptionMap->put($exception, $mapper);
        });
    }

    public function extendExceptionMap(callable $callback): self
    {
        $this->exceptionMap = $callback($this->exceptionMap);

        return $this;
    }

    public function tapExceptionMap(callable $callback): self
    {
        tap($this->exceptionMap, $callback);

        return $this;
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::mapException()
     *
     * @return \Throwable|array{
     *     message: string,
     *     code: int,
     *     error: ?array,
     *     headers: array,
     * }
     */
    private function mapException(\Throwable $throwable)
    {
        $mapper = $this->exceptionMap->first(
            static fn ($mapper, string $exception): bool => $throwable instanceof $exception,
            []
        );

        return \is_callable($mapper) || (!\is_array($mapper) && !$mapper instanceof \Throwable)
            ? app()->call($mapper, ['throwable' => $throwable])
            : $mapper;
    }
}
