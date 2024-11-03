<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Support\Utils;
use Symfony\Component\HttpFoundation\Response;

it('can return status code', function (int $code, int $statusCode): void {
    expect(Utils::statusCodeFor($code))->toBe($statusCode);
})->group(__DIR__, __FILE__)->with([
    ['code' => -99, 'status_code' => -99],
    ['code' => -999999, 'status_code' => -99],
    ['code' => 0, 'status_code' => 0],
    ['code' => 99, 'status_code' => 99],
    ['code' => 999999, 'status_code' => 999],
    ['code' => Response::HTTP_CONTINUE, 'status_code' => Response::HTTP_CONTINUE],
    ['code' => 100000, 'status_code' => Response::HTTP_CONTINUE],
    ['code' => 600, 'status_code' => 600],
    ['code' => 600000, 'status_code' => 600],
]);

it('can validate code', function (int $code, bool $isValid): void {
    expect(Utils::isValidCode($code))->toBe($isValid);
})->group(__DIR__, __FILE__)->with([
    ['code' => -99, 'is_valid' => false],
    ['code' => -999999, 'is_valid' => false],
    ['code' => 0, 'is_valid' => false],
    ['code' => 99, 'is_valid' => false],
    ['code' => 999999, 'is_valid' => false],
    ['code' => Response::HTTP_CONTINUE, 'is_valid' => true],
    ['code' => 100000, 'is_valid' => true],
    ['code' => 600, 'is_valid' => false],
    ['code' => 600000, 'is_valid' => false],
]);
