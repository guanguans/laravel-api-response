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

namespace Guanguans\LaravelApiResponse\Support;

use Symfony\Component\HttpFoundation\Response;

class Utils
{
    public static function statusCodeFor(int|string $code): int
    {
        return (int) substr((string) $code, 0, 3);
    }

    public static function isValidCode(int|string $code): bool
    {
        return self::isValidStatusCode(self::statusCodeFor($code));
    }

    public static function isValidStatusCode(int $statusCode): bool
    {
        return Response::HTTP_CONTINUE <= $statusCode && 600 > $statusCode;
    }

    public static function isValidErrorCode(int|string $code): bool
    {
        return self::isValidErrorStatusCode(self::statusCodeFor($code));
    }

    public static function isValidErrorStatusCode(int $statusCode): bool
    {
        return Response::HTTP_BAD_REQUEST <= $statusCode && 600 > $statusCode;
    }
}
