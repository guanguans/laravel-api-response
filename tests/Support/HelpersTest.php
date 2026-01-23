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

use Guanguans\LaravelApiResponse\ApiResponse;
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

it('can make api response', function (array|string $abstract): void {
    expect(make($abstract))->toBeInstanceOf(ApiResponse::class);
})->group(__DIR__, __FILE__)->with([
    ['abstract' => ApiResponse::class],
    ['abstract' => ['__abstract' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['__class' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['__name' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['_abstract' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['_class' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['_name' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['abstract' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['class' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
    ['abstract' => ['name' => ApiResponse::class, 'pipes' => collect(), 'exceptionPipes' => collect()]],
]);

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
