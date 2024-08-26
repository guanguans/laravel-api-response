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

use Guanguans\LaravelApiResponse\Pipes\ErrorPipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can return a JsonResponse', function (): void {
    expect($this->apiResponse())
        ->pushPipes(ErrorPipe::with(true))
        ->exception(new HttpException(500))->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(50000))->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(-1))->toBeInstanceOf(JsonResponse::class)
        ->pushPipes(StatusCodePipe::with())
        ->success(new Paginator([], 15))->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);
