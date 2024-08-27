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

use Guanguans\LaravelApiResponse\ExceptionPipes\SetCodeExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetErrorExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetHeadersExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetMessageExceptionPipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can use exception pipes', function (): void {
    expect($this->apiResponse())
        ->pushExceptionPipes(
            SetCodeExceptionPipe::with(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                \Throwable::class,
            ),
            SetMessageExceptionPipe::with(
                'Server Error',
                \Throwable::class,
            ),
            SetHeadersExceptionPipe::make(
                [
                    'X-Foo' => 'Bar',
                ],
                \Throwable::class,
            ),
            SetErrorExceptionPipe::make(
                [
                    'message' => 'Server Error',
                ],
                \Throwable::class,
            )
        )
        ->exception(new HttpException(500))->toBeInstanceOf(JsonResponse::class)
        ->exception(new ValidationException(Validator::make(['foo' => 'bar'], ['bar' => ['int']])))->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);
