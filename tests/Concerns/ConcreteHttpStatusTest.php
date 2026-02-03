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

use Illuminate\Http\JsonResponse;
use Pest\Expectation;

it('can use success http status methods', function (): void {
    expect([
        'ok',
        'created',
        'accepted',
        'noContent',
    ])->each(function (Expectation $expectation): void {
        expect($this->apiResponse()->{$expectation->value}())
            ->toBeInstanceOf(JsonResponse::class)
            ->isSuccessful()->toBeTrue();
    });
})->group(__DIR__, __FILE__);

it('can use client error http status methods', function (): void {
    expect([
        'badRequest',
        'unauthorized',
        'paymentRequired',
        'forbidden',
        'notFound',
        'methodNotAllowed',
        'requestTimeout',
        'conflict',
        'teapot',
        'unprocessableEntity',
        'tooManyRequests',
    ])->each(function (Expectation $expectation): void {
        expect($this->apiResponse()->{$expectation->value}())
            ->toBeInstanceOf(JsonResponse::class)
            ->isClientError()->toBeTrue();
    });
})->group(__DIR__, __FILE__);
