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

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {});

it('is exception handler', function (bool $debug): void {
    config()->set('app.debug', $debug);
    $response = $this->post('api/exception');
    $response->assertStatus(Response::HTTP_BAD_REQUEST);
    assertMatchesJsonSnapshot((string) Str::of($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->with('debugs')->skip();

it('is exception', function (bool $debug): void {
    config()->set('app.debug', $debug);
    $runtimeException = new \RuntimeException('This is a runtime exception.', Response::HTTP_BAD_REQUEST);
    $response = $this->apiResponse()->exception($runtimeException);
    expect($response)->isClientError()->toBeTrue();
    $response->assertStatus(Response::HTTP_BAD_REQUEST);
    assertMatchesJsonSnapshot((string) Str::of($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->with('debugs')->skip();

it('is authentication exception', function (string $language): void {
    config()->set('app.locale', $language);
    $authenticationException = new AuthenticationException;
    assertMatchesJsonSnapshot($this->apiResponse()->exception($authenticationException)->content());
})->group(__DIR__, __FILE__)->with('languages');

it('is http exception', function (string $language): void {
    config()->set('app.locale', $language);
    $httpException = new HttpException(Response::HTTP_NOT_FOUND);
    assertMatchesJsonSnapshot($this->apiResponse()->exception($httpException)->content());
})->group(__DIR__, __FILE__)->with('languages');

it('is validation exception', function (string $language): void {
    config()->set('app.locale', $language);
    $validationException = new ValidationException(
        Validator::make(
            ['foo' => 'bar', 'bar' => 'baz'],
            ['foo' => ['required', 'int', 'in:1,2'], 'bar' => ['email'], 'baz' => ['required', 'string']]
        )
    );
    assertMatchesJsonSnapshot($this->apiResponse()->exception($validationException)->content());
})->group(__DIR__, __FILE__)->with('languages');
