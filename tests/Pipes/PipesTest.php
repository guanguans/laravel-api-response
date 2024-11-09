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

use Guanguans\LaravelApiResponse\Pipes\CastDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ErrorPipe;
use Guanguans\LaravelApiResponse\Pipes\NullDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('can use pipes', function (): void {
    expect($this->apiResponse())
        ->pushPipes(
            ErrorPipe::with(true),
            NullDataPipe::with(false),
            ScalarDataPipe::with(JsonResource::$wrap),
        )
        ->success($this->faker()->name())->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(500000))->toBeInstanceOf(JsonResponse::class)
        ->exception(new HttpException(600))->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);

it('can will throw InvalidArgumentException', function ($data): void {
    $this->apiResponse()->castToFloat()->success($data);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class)->with([
    'Infinity',
    '-Infinity',
    'NaN',
]);

it('can will throw Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException', function (): void {
    $this->apiResponse()->castTo('resource')->success($this->faker()->name());
})->group(__DIR__, __FILE__)->throws(Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException::class, 'resource');

it('can ', function (?array $only, ?array $except): void {
    expect($this->apiResponse())
        ->pushPipes(CastDataPipe::make('integer', $only, $except))
        ->success($this->faker()->phoneNumber())
        ->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__)->with([
    ['only' => null, 'except' => null],
    ['only' => ['*'], 'except' => null],
    ['only' => null, 'except' => []],
    ['only' => ['*'], 'except' => []],
]);
