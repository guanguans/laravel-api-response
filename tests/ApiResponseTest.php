<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Pipes\CallableDataPipe;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can return JsonResponse', function (): void {
    $this
        ->apiResponse()
        ->dump()
        ->beforePipes(CallableDataPipe::with(), fn (array $data, $next) => $next($data), fn (array $data, $next) => $next($data))
        ->afterPipes(CallableDataPipe::with(), fn (array $data, $next) => $next($data), fn (array $data, $next) => $next($data))
        ->removePipes(CallableDataPipe::with(), CallableDataPipe::with())
        ->dump();

    expect($this->apiResponse()->exception(new HttpException(Response::HTTP_BAD_REQUEST, $this->faker()->title())))
        ->toBeInstanceOf(JsonResponse::class)
        ->isClientError()->toBeTrue()
        ->and($this->apiResponse()->exception(new \RuntimeException($this->faker()->title(), 0)))
        ->toBeInstanceOf(JsonResponse::class)
        ->isServerError()->toBeTrue()
        ->and($this->apiResponse()->exception(new \RuntimeException($this->faker()->title(), 99)))
        ->toBeInstanceOf(JsonResponse::class)
        ->isServerError()->toBeTrue()
        ->and($this->apiResponse()->exception(new \RuntimeException($this->faker()->title(), Response::HTTP_BAD_REQUEST)))
        ->toBeInstanceOf(JsonResponse::class)
        ->isClientError()->toBeTrue()
        ->and($this->apiResponse()->exception(new \RuntimeException($this->faker()->title(), 600)))
        ->toBeInstanceOf(JsonResponse::class)
        ->isServerError()->toBeTrue();
})->group(__DIR__, __FILE__);
