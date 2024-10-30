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

use Composer\Semver\Comparator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

it('is exception handler', function (): void {
    $response = $this->post('exception');
    $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

    assertMatchesJsonSnapshot($response->content());
})->group(__DIR__, __FILE__);

it('is debug exception handler', function (): void {
    $response = $this->post('debug-exception');
    $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

    assertMatchesJsonSnapshot((string) Str::of($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0'));

it('is exception', function (): void {
    config()->set('app.debug', false);
    $runtimeException = new \RuntimeException('This is a runtime exception.');
    assertMatchesJsonSnapshot($this->apiResponse()->exception($runtimeException)->content());
})->group(__DIR__, __FILE__);

it('is debug exception', function (): void {
    config()->set('app.debug', true);
    $runtimeException = new \RuntimeException('This is a runtime exception.');
    $response = $this->apiResponse()->exception($runtimeException);
    assertMatchesJsonSnapshot((string) Str::of($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0'));

it('is http exception', function (): void {
    config()->set('app.debug', false);
    $httpException = new HttpException(Response::HTTP_NOT_FOUND, 'This is a http exception.');
    assertMatchesJsonSnapshot($this->apiResponse()->exception($httpException)->content());
})->group(__DIR__, __FILE__);

it('is authentication exception', function (): void {
    config()->set('app.debug', false);
    $authenticationException = new AuthenticationException;
    assertMatchesJsonSnapshot($this->apiResponse()->exception($authenticationException)->content());
})->group(__DIR__, __FILE__);

it('is validation exception', function (): void {
    config()->set('app.debug', false);
    $validationException = new ValidationException(
        Validator::make(
            ['foo' => 'bar', 'bar' => 'baz'],
            ['foo' => ['required', 'int'], 'bar' => ['required', 'email'], 'baz' => ['required', 'string']]
        )
    );
    assertMatchesJsonSnapshot($this->apiResponse()->exception($validationException)->content());
})->group(__DIR__, __FILE__);

it('is locale exception', function (): void {
    config()->set('app.debug', false);
    config()->set('app.locale', 'zh_CN');

    $runtimeException = new \RuntimeException('This is a runtime exception.');
    assertMatchesJsonSnapshot($this->apiResponse()->exception($runtimeException)->content());
})->group(__DIR__, __FILE__);
