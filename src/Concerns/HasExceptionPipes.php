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

namespace Guanguans\LaravelApiResponse\Concerns;

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;

/**
 * @mixin \Guanguans\LaravelApiResponse\ApiResponse
 */
trait HasExceptionPipes
{
    /**
     * @see \Illuminate\Pipeline\Pipeline::carry()
     *
     * @var \Illuminate\Support\Collection<int, callable|object|string>
     */
    protected Collection $exceptionPipes;

    /**
     * @noinspection PhpStaticAsDynamicMethodCallInspection
     */
    public function unshiftExceptionPipes(mixed ...$exceptionPipes): self
    {
        return $this->tapExceptionPipes(static function (Collection $originalExceptionPipes) use ($exceptionPipes): void {
            $originalExceptionPipes->unshift(...$exceptionPipes);
        });
    }

    public function pushExceptionPipes(mixed ...$exceptionPipes): self
    {
        return $this->tapExceptionPipes(static function (Collection $originalExceptionPipes) use ($exceptionPipes): void {
            $originalExceptionPipes->push(...$exceptionPipes);
        });
    }

    public function beforeExceptionPipes(string $findExceptionPipe, mixed ...$exceptionPipes): self
    {
        return $this->spliceExceptionPipes($findExceptionPipe, $exceptionPipes, true);
    }

    public function afterExceptionPipes(string $findExceptionPipe, mixed ...$exceptionPipes): self
    {
        return $this->spliceExceptionPipes($findExceptionPipe, $exceptionPipes, false);
    }

    public function removeExceptionPipes(string ...$findExceptionPipes): self
    {
        return $this->extendExceptionPipes(
            static fn (Collection $exceptionPipes): Collection => $exceptionPipes
                ->reject(static function (callable|object|string $exceptionPipe) use ($findExceptionPipes): bool {
                    if (\is_object($exceptionPipe) && !$exceptionPipe instanceof \Closure) {
                        $exceptionPipe = $exceptionPipe::class;
                    }

                    if (!\is_string($exceptionPipe)) {
                        return false;
                    }

                    return str($exceptionPipe)->startsWith($findExceptionPipes);
                })
                ->values()
        );
    }

    /**
     * @param callable(\Illuminate\Support\Collection<int, callable|object|string>): \Illuminate\Support\Collection<int, callable|object|string> $callback
     */
    public function extendExceptionPipes(callable $callback): self
    {
        $this->exceptionPipes = $this->exceptionPipes->pipe($callback);

        return $this;
    }

    public function tapExceptionPipes(callable $callback): self
    {
        tap($this->exceptionPipes, $callback);

        return $this;
    }

    /**
     * @param list<callable|object|string> $exceptionPipes
     *
     * @noinspection StaticInvocationViaThisInspection
     * @noinspection PhpStaticAsDynamicMethodCallInspection
     */
    private function spliceExceptionPipes(string $findExceptionPipe, array $exceptionPipes, bool $before): self
    {
        $idx = $this->findByExceptionPipe($findExceptionPipe);

        if ($before) {
            if (0 === $idx) {
                $this->exceptionPipes->unshift(...$exceptionPipes);
            } else {
                $this->exceptionPipes->splice($idx, 1, [...$exceptionPipes, $this->exceptionPipes->get($idx)]);
            }
        } elseif ($this->exceptionPipes->count() - 1 === $idx) {
            $this->exceptionPipes->push(...$exceptionPipes);
        } else {
            $this->exceptionPipes->splice($idx, 1, [$this->exceptionPipes->get($idx), ...$exceptionPipes]);
        }

        return $this;
    }

    private function findByExceptionPipe(string $findExceptionPipe): int
    {
        foreach ($this->exceptionPipes as $idx => $exceptionPipe) {
            if (\is_object($exceptionPipe) && !$exceptionPipe instanceof \Closure) {
                $exceptionPipe = $exceptionPipe::class;
            }

            if (\is_string($exceptionPipe) && str($exceptionPipe)->startsWith($findExceptionPipe)) {
                return $idx;
            }
        }

        throw new InvalidArgumentException("ExceptionPipe not found: $findExceptionPipe");
    }
}
