<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Tests;

use Guanguans\LaravelApiResponse\ApiResponseServiceProvider;
use Guanguans\LaravelApiResponse\Facades\ApiResponse;
use Guanguans\LaravelApiResponse\Middleware\SetAcceptHeader;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;
    use Faker;
    use ApiResponseFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->startMockery();
    }

    protected function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ApiResponseServiceProvider::class,
        ];
    }

    /**
     * @see https://github.com/staudenmeir
     */
    protected function defineDatabaseMigrations(): void {}

    protected function defineEnvironment($app): void {}

    protected function defineRoutes($router): void
    {
        $router->any('success', static fn (Request $request) => ApiResponse::success($request->input()));
        $router->any('error', static fn (Request $request) => ApiResponse::error());
        $router->any('throw', static function (): void {
            $app = app(ExceptionHandler::class);

            // dd($app);
            throw new \RuntimeException('error');
        })->middleware(SetAcceptHeader::class);
    }
}
