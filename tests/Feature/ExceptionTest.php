<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Composer\Semver\Comparator;
use Guanguans\LaravelApiResponseTests\Laravel\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {});

it('is runtime exception handler', function (bool $debug): void {
    if ($debug && Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0')) {
        expect(true)->toBeTrue();

        return;
    }

    config()->set('app.debug', $debug);
    $response = $this->post('api/exception');
    $response->assertStatus(Response::HTTP_BAD_GATEWAY);
    assertMatchesJsonSnapshot((string) str($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->with('debugs');

it('is runtime exception', function (bool $debug): void {
    if ($debug && Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0')) {
        expect(true)->toBeTrue();

        return;
    }

    config()->set('app.debug', $debug);
    $runtimeException = new RuntimeException('This is a runtime exception.', Response::HTTP_BAD_REQUEST);
    $response = $this->apiResponse()->exception($runtimeException);
    expect($response)->getStatusCode()->toBe(Response::HTTP_BAD_REQUEST);
    assertMatchesJsonSnapshot((string) str($response->content())->remove(\dirname(__DIR__, 2)));
})->group(__DIR__, __FILE__)->with('debugs');

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

it('is query exception', function (string $language): void {
    try {
        config()->set('app.locale', $language);
        User::query()->groupByRaw('no_such_column')->get();
    } catch (QueryException $queryException) {
        dump($queryException->getCode(), $queryException->getMessage());
        assertMatchesJsonSnapshot($this->apiResponse()->exception($queryException)->content());
    }
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
