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

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
     * @param mixed $pipe
     */
    public function before(string $findPipe, $pipe): self
    {
        return $this->splice($findPipe, $pipe, true);
    }

    /**
     * @param mixed $pipe
     */
    public function after(string $findPipe, $pipe): self
    {
        return $this->splice($findPipe, $pipe, false);
    }

    public function remove(string $findPipe): self
    {
        return $this->extendPipes(
            fn (Collection $pipes): Collection => $this
                ->pipes
                ->reject(static fn ($pipe): bool => $pipe === $findPipe)
                ->values()
        );
    }

    /**
     * @param mixed $pipe
     */
    private function splice(string $findPipe, $pipe, bool $before): self
    {
        $idx = $this->findByPipe($findPipe);

        if ($before) {
            if (0 === $idx) {
                $this->pipes->unshift($pipe);
            } else {
                $replacement = [$pipe, $this->pipes[$idx]];
                $this->pipes->splice($idx, 1, $replacement);
            }
        } elseif ($this->pipes->count() - 1 === $idx) {
            $this->pipes[] = $pipe;
        } else {
            $replacement = [$this->pipes[$idx], $pipe];
            $this->pipes->splice($idx, 1, $replacement);
        }

        return $this;
    }

    private function findByPipe(string $findPipe): int
    {
        foreach ($this->pipes as $idx => $pipe) {
            if (\is_string($pipe) && Str::of($pipe)->startsWith($findPipe)) {
                return $idx;
            }
        }

        throw new InvalidArgumentException("Pipe not found: $findPipe");
    }
}
