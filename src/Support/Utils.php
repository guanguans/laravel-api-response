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

namespace Guanguans\LaravelApiResponse\Support;

class Utils
{
    public static function statusCodeFor(int $code): int
    {
        // return (int) str_pad(substr((string) $code, 0, 3), 3, '0');
        return (int) substr((string) $code, 0, 3);
    }
}
