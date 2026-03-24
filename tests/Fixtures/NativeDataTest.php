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

namespace Guanguans\LaravelApiResponseTests\Fixtures;

use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;

class NativeDataTest
{
    use MakeStaticable;

    public function __invoke(): string
    {
        return __METHOD__;
    }

    public static function staticMethod(): string
    {
        return __METHOD__;
    }

    public function generalMethod(): string
    {
        return __METHOD__;
    }
}
