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

trait WithPipeArgs
{
    public static function with(...$args): string
    {
        if ([] === $args) {
            return static::class;
        }

        return static::class.':'.implode(',', $args);
    }
}
