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

use Guanguans\LaravelApiResponse\ExceptionPipes\HideOriginalMessageExceptionPipe;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can use pipes', function (): void {
    expect($this->apiResponse())
        ->pushExceptionPipes(HideOriginalMessageExceptionPipe::with(AuthenticationException::class))
        ->exception(new HttpException(500))->toBeInstanceOf(JsonResponse::class)
        ->exception(new ValidationException(Validator::make(['foo' => 'bar'], ['bar' => ['int']])))->toBeInstanceOf(JsonResponse::class)
        ->exception(new AuthenticationException)->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);
