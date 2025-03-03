<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Pest\Expectation;
use function Guanguans\LaravelApiResponse\Support\env_explode;
use function Guanguans\LaravelApiResponse\Support\make;

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */
it('will throw `InvalidArgumentException` when abstract is empty array', function (): void {
    make([]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can make api response', function (): void {
    expect(make(['class' => ApiResponseContract::class]))->toBeInstanceOf(ApiResponseContract::class);
})->group(__DIR__, __FILE__);

it('can explode env', function (): void {
    expect([
        env_explode('ENV_EXPLODE_STRING'),
        env_explode('ENV_EXPLODE_EMPTY'),
        env_explode('ENV_EXPLODE_NOT_EXIST'),
        // env_explode('ENV_EXPLODE_FALSE'),
        // env_explode('ENV_EXPLODE_NULL'),
        // env_explode('ENV_EXPLODE_TRUE'),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeTruthy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeFalsy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeFalse(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeTrue(),
    );
})->group(__DIR__, __FILE__);
