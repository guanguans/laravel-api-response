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

use Guanguans\LaravelApiResponse\Concerns\ConcreteHttpStatus;
use Illuminate\Http\JsonResponse;
use Pest\Expectation;
use Symfony\Component\HttpFoundation\Response;

it('can use success http status methods', function (): void {
    expect(
        collect((new ReflectionClass(ConcreteHttpStatus::class))->getMethods())
            ->filter(
                fn (ReflectionMethod $reflectionMethod): bool => (new Response(
                    status: \constant(Response::class.'::'.str($reflectionMethod->name)->snake()->start('HTTP_')->upper()->toString())
                ))->isSuccessful()
            )
            ->map(fn (ReflectionMethod $reflectionMethod): string => $reflectionMethod->getName())
            ->all()
    )->each(function (Expectation $expectation): void {
        expect($this->apiResponse()->{$expectation->value}())
            ->toBeInstanceOf(JsonResponse::class)
            ->isSuccessful()->toBeTrue();
    });
})->group(__DIR__, __FILE__);

it('can use client error http status methods', function (): void {
    expect(
        collect((new ReflectionClass(ConcreteHttpStatus::class))->getMethods())
            ->filter(
                fn (ReflectionMethod $reflectionMethod): bool => (new Response(
                    status: \constant(Response::class.'::'.str($reflectionMethod->name)->snake()->start('HTTP_')->upper()->toString())
                ))->isClientError()
            )
            ->map(fn (ReflectionMethod $reflectionMethod): string => $reflectionMethod->getName())
            ->all()
    )->each(function (Expectation $expectation): void {
        expect($this->apiResponse()->{$expectation->value}())
            ->toBeInstanceOf(JsonResponse::class)
            ->isClientError()->toBeTrue();
    });
})->group(__DIR__, __FILE__);
