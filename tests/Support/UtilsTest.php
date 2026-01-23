<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpInternalEntityUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
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
    ['code' => -99, 'statusCode' => -99],
    ['code' => -999999, 'statusCode' => -99],
    ['code' => 0, 'statusCode' => 0],
    ['code' => 99, 'statusCode' => 99],
    ['code' => 999999, 'statusCode' => 999],
    ['code' => Response::HTTP_CONTINUE, 'statusCode' => Response::HTTP_CONTINUE],
    ['code' => 100000, 'statusCode' => Response::HTTP_CONTINUE],
    ['code' => 600, 'statusCode' => 600],
    ['code' => 600000, 'statusCode' => 600],
]);

it('can validate code', function (int $code, bool $isValid): void {
    expect(Utils::isValidCode($code))->toBe($isValid);
})->group(__DIR__, __FILE__)->with([
    ['code' => -99, 'isValid' => false],
    ['code' => -999999, 'isValid' => false],
    ['code' => 0, 'isValid' => false],
    ['code' => 99, 'isValid' => false],
    ['code' => 999999, 'isValid' => false],
    ['code' => Response::HTTP_CONTINUE, 'isValid' => true],
    ['code' => 100000, 'isValid' => true],
    ['code' => 600, 'isValid' => false],
    ['code' => 600000, 'isValid' => false],
]);
