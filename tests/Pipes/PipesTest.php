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
use Guanguans\LaravelApiResponse\Pipes\JsonResourceDataPipe;
use Guanguans\LaravelApiResponse\Pipes\MessagePipe;
use Guanguans\LaravelApiResponse\Pipes\NullDataPipe;
use Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Guanguans\LaravelApiResponse\Pipes\ToJsonResponseDataPipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can use pipes', function (): void {
    JsonResource::withoutWrapping();
    expect($this->apiResponse())
        ->unshiftPipes(ScalarDataPipe::with(true, JsonResource::$wrap))
        ->pushPipes(
            /*
             * Before...
             */
            JsonResourceDataPipe::class,
            NullDataPipe::with(true),
            ScalarDataPipe::with(true, JsonResource::$wrap),
            PaginatorDataPipe::class,
            ToJsonResponseDataPipe::class,
            MessagePipe::with('http-statuses', 'Server Error'),
            ErrorPipe::with(true),

            /*
             * After...
             */
            StatusCodePipe::with(Response::HTTP_INTERNAL_SERVER_ERROR, Response::HTTP_OK),
        )
        ->success($this->faker()->name())->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(500000))->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(600))->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);
