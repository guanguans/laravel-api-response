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
}
