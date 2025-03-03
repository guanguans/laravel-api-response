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

namespace Guanguans\LaravelApiResponse\Concerns;

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;

/**
 * @see https://github.com/guzzle/guzzle/blob/8.0/src/HandlerStack.php
 * @see \GuzzleHttp\HandlerStack
 *
 * @mixin \Guanguans\LaravelApiResponse\ApiResponse
 */
trait HasPipes
{
    protected Collection $pipes;

    public function unshiftPipes(...$pipes): self
    {
        return $this->tapPipes(static function (Collection $originalPipes) use ($pipes): void {
            $originalPipes->unshift(...$pipes);
        });
    }

    public function pushPipes(...$pipes): self
    {
        return $this->tapPipes(static function (Collection $originalPipes) use ($pipes): void {
            $originalPipes->push(...$pipes);
        });
    }

    public function beforePipes(string $findPipe, ...$pipes): self
    {
        return $this->splicePipes($findPipe, $pipes, true);
    }

    public function afterPipes(string $findPipe, ...$pipes): self
    {
        return $this->splicePipes($findPipe, $pipes, false);
    }

    public function removePipes(string ...$findPipes): self
    {
        return $this->extendPipes(
            static fn (Collection $pipes): Collection => $pipes
                ->reject(static function ($pipe) use ($findPipes): bool {
                    if (\is_object($pipe) && !$pipe instanceof \Closure) {
                        $pipe = $pipe::class;
                    }

                    if (!\is_string($pipe)) {
                        return false;
                    }

                    return str($pipe)->startsWith($findPipes);
                })
                ->values()
        );
    }

    public function extendPipes(callable $callback): self
    {
        $this->pipes = $this->pipes->pipe($callback);

        return $this;
    }

    public function tapPipes(callable $callback): self
    {
        tap($this->pipes, $callback);

        return $this;
    }

    /**
     * @param list<mixed> $pipes
     */
    private function splicePipes(string $findPipe, array $pipes, bool $before): self
    {
        $idx = $this->findByPipe($findPipe);

        if ($before) {
            if (0 === $idx) {
                $this->pipes->unshift(...$pipes);
            } else {
                $this->pipes->splice($idx, 1, [...$pipes, $this->pipes[$idx]]);
            }
        } elseif ($this->pipes->count() - 1 === $idx) {
            $this->pipes->push(...$pipes);
        } else {
            $this->pipes->splice($idx, 1, [$this->pipes[$idx], ...$pipes]);
        }

        return $this;
    }

    private function findByPipe(string $findPipe): int
    {
        foreach ($this->pipes as $idx => $pipe) {
            if (\is_object($pipe) && !$pipe instanceof \Closure) {
                $pipe = $pipe::class;
            }

            if (\is_string($pipe) && str($pipe)->startsWith($findPipe)) {
                return $idx;
            }
        }

        throw new InvalidArgumentException("Pipe not found: $findPipe");
    }
}
