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
trait HasExceptionPipes
{
    protected Collection $exceptionPipes;

    public function unshiftExceptionPipes(...$exceptionPipes): self
    {
        return $this->tapExceptionPipes(static function (Collection $originalExceptionPipes) use ($exceptionPipes): void {
            $originalExceptionPipes->unshift(...$exceptionPipes);
        });
    }

    public function pushExceptionPipes(...$exceptionPipes): self
    {
        return $this->tapExceptionPipes(static function (Collection $originalExceptionPipes) use ($exceptionPipes): void {
            $originalExceptionPipes->push(...$exceptionPipes);
        });
    }

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
}
