<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

it('can cast type', function ($data): void {
    expect($this->apiResponse()->castToNull()->success($data)->getData(true)['data'])->toBeNull()
        ->and($this->apiResponse()->castToNull()->success($data)->getData()->data)->toBeNull()
        ->and($this->apiResponse()->castToInteger()->success($data)->getData(true)['data'])->toBeInt()
        ->and($this->apiResponse()->castToInteger()->success($data)->getData()->data)->toBeInt()
        ->and($this->apiResponse()->castToFloat()->success($data)->getData(true)['data'])->toBeNumeric() // 0, float
        ->and($this->apiResponse()->castToFloat()->success($data)->getData()->data)->toBeNumeric() // 0, float
        ->and($this->apiResponse()->castToString()->success($data)->getData(true)['data'])->toBeString()
        ->and($this->apiResponse()->castToString()->success($data)->getData()->data)->toBeString()
        ->and($this->apiResponse()->castToBoolean()->success($data)->getData(true)['data'])->toBeBool()
        ->and($this->apiResponse()->castToBoolean()->success($data)->getData()->data)->toBeBool()
        ->and($this->apiResponse()->castToArray()->success($data)->getData(true)['data'])->toBeArray()
        // ->and($this->apiResponse()->castToArray()->success($data)->getData()->data)->toBeArray()
        // ->and($this->apiResponse()->castToObject()->success($data)->getData(true)['data'])->toBeObject()
        ->and($this->apiResponse()->castToObject()->success($data)->getData()->data)->toBeObject();
})->group(__DIR__, __FILE__)->with([
    null,
    1,
    1.1,
    'string',
    true,
    fn (): array => [],
    fn (): array => ['foo', 'bar', 'baz'],
    fn (): array => ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
    (object) [],
    (object) ['foo', 'bar', 'baz'],
    (object) ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
]);
