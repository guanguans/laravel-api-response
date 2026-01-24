<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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

use Guanguans\LaravelApiResponse\ApiResponse;
use Guanguans\LaravelApiResponse\ExceptionPipes\AuthenticationExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetCodeExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetHeadersExceptionPipe;
use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;

it('can throw InvalidArgumentException', function (): void {
    $this->apiResponse()->beforeExceptionPipes(self::class);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can use exception pipes', function (): void {
    expect($this->apiResponse())
        ->unshiftExceptionPipes()
        ->pushExceptionPipes()
        ->beforeExceptionPipes(
            AuthenticationExceptionPipe::with(),
            static fn (Throwable $throwable, Closure $next): array => $next($throwable),
            static fn (Throwable $throwable, Closure $next): array => $next($throwable),
        )
        ->beforeExceptionPipes(
            SetCodeExceptionPipe::with(),
            static fn (Throwable $throwable, Closure $next): array => $next($throwable),
        )
        ->afterExceptionPipes(
            SetCodeExceptionPipe::with(),
            static fn (Throwable $throwable, Closure $next): array => $next($throwable),
        )
        ->afterExceptionPipes(
            SetHeadersExceptionPipe::with(),
            static fn (Throwable $throwable, Closure $next): array => $next($throwable),
        )
        ->removeExceptionPipes(
            SetCodeExceptionPipe::with(),
            SetCodeExceptionPipe::with()
        )
        ->tapExceptionPipes(static function (Collection $exceptionPipes): void {
            expect($exceptionPipes->toJson(\JSON_PRETTY_PRINT))->toMatchSnapshot();
        })
        ->toBeInstanceOf(ApiResponse::class);
})->group(__DIR__, __FILE__);
