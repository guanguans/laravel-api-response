<?php

/** @noinspection PhpUndefinedClassInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\ApiResponse;
use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Guanguans\LaravelApiResponse\Pipes\CallableDataPipe;
use Guanguans\LaravelApiResponse\Pipes\MessagePipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use function Spatie\Snapshots\assertMatchesObjectSnapshot;

it('can throw InvalidArgumentException', function (): void {
    $this->apiResponse()->beforePipes(self::class);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class);

it('can use pipes', function (): void {
    expect($this->apiResponse())
        ->unshiftPipes()
        ->pushPipes()
        ->beforePipes(
            MessagePipe::with(),
            static fn (array $structure, Closure $next): JsonResponse => $next($structure),
            static fn (array $structure, Closure $next): JsonResponse => $next($structure),
            new class {
                public function handle(array $structure, Closure $next): JsonResponse
                {
                    return $next($structure);
                }
            }
        )
        ->beforePipes(
            CallableDataPipe::with(),
            static fn (array $structure, Closure $next): JsonResponse => $next($structure),
        )
        ->afterPipes(
            CallableDataPipe::with(),
            static fn (array $structure, Closure $next): JsonResponse => $next($structure),
        )
        ->afterPipes(
            StatusCodePipe::with(),
            static fn (array $structure, Closure $next): JsonResponse => $next($structure),
        )
        ->removePipes(
            CallableDataPipe::with(),
            CallableDataPipe::with(),
            'class@anonymous'
        )
        ->tapPipes(static function (Collection $pipes): void {
            assertMatchesObjectSnapshot($pipes);
        })
        ->toBeInstanceOf(ApiResponse::class);
})->group(__DIR__, __FILE__);
