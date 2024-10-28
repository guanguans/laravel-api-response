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
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
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

it('is locale exception', function (): void {
    config()->set('app.debug', false);
    config()->set('app.locale', 'zh_CN');

    $runtimeException = new \RuntimeException('This is a runtime exception.');
    assertMatchesJsonSnapshot($this->apiResponse()->exception($runtimeException)->content());
})->group(__DIR__, __FILE__);
