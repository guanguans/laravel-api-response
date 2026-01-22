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

use Guanguans\LaravelApiResponse\Pipes\CastDataPipe;

/**
 * @mixin \Guanguans\LaravelApiResponse\ApiResponse
 */
trait ConcreteCast
{
    public function castToNull(): self
    {
        return $this->castTo('null');
    }

    public function castToInteger(): self
    {
        return $this->castTo('integer');
    }

    public function castToFloat(): self
    {
        return $this->castTo('float');
    }

    public function castToString(): self
    {
        return $this->castTo('string');
    }

    public function castToBoolean(): self
    {
        return $this->castTo('boolean');
    }

    public function castToObject(): self
    {
        return $this->castTo('object');
    }

    public function castToArray(): self
    {
        return $this->castTo('array');
    }

    public function castTo(string $type): self
    {
        return $this->pushPipes(CastDataPipe::make($type));
    }
}
