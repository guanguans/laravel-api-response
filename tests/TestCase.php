<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Tests;

use Guanguans\LaravelApiResponse\ApiResponseServiceProvider;
use Guanguans\LaravelApiResponse\Facades\ApiResponse;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;
    use Faker;

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

    protected function defineEnvironment($app): void
    {
        // config()->set('exception-notify.job.queue', 'exception-notify');
    }

    protected function defineRoutes($router): void
    {
        $router->any('report-exception', static fn () => tap(response('report-exception'), static function (): void {
            ApiResponse::report(new \Guanguans\LaravelApiResponse\Exceptions\RuntimeException('What happened?'), ['dump', 'log', 'bark', 'lark']);
        }));

        $router->any('exception', static fn () => tap(response('exception'), static function (): void {
            throw new \Guanguans\LaravelApiResponse\Exceptions\RuntimeException('What happened?');
        }));
    }
}
