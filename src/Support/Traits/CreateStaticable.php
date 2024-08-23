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

namespace Guanguans\LaravelApiResponse\Support\Traits;

trait CreateStaticable
{
    public static function create(...$parameters): self
    {
        return static::new(...$parameters);
    }

    public static function make(...$parameters): self
    {
        return static::new(...$parameters);
    }

    /**
     * @noinspection PhpMethodParametersCountMismatchInspection
     */
    public static function new(...$parameters): self
    {
        return new static(...$parameters);
    }
}
