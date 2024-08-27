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
use Guanguans\LaravelApiResponse\Pipes\MessagePipe;
use Guanguans\LaravelApiResponse\Pipes\NullDataPipe;
use Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Guanguans\LaravelApiResponse\Pipes\ToJsonResponseDataPipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can use pipes', function (): void {
    JsonResource::$wrap = null;
    expect($this->apiResponse())
        ->pushPipes(
            /*
             * Before...
             */
            PaginatorDataPipe::class,
            NullDataPipe::with(true),
            ScalarDataPipe::with(true),
            ToJsonResponseDataPipe::class,
            MessagePipe::with(),
            ErrorPipe::with(true),

            /*
             * After...
             */
            StatusCodePipe::with(),
        )
        ->unshiftPipes(ScalarDataPipe::with(true))
        ->exception(new HttpException(600))->toBeInstanceOf(JsonResponse::class)
        ->success()->toBeInstanceOf(JsonResponse::class)
        ->success(1)->toBeInstanceOf(JsonResponse::class)
        ->success(new Paginator([], 15))->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);
