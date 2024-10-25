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
use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Guanguans\LaravelApiResponse\Middleware\SetAcceptHeader;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\seeders\TablesSeeder;
use Illuminate\Contracts\Debug\ExceptionHandler;
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
        $this->app->useLangPath(__DIR__.'/Laravel/lang');
        $this->startMockery();
    }

    protected function tearDown(): void
    {
        // (require __DIR__.'/migrations/create_tables.php')->down();
        $this->closeMockery();
        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return array_merge(
            parent::getPackageProviders($app),
            [
                ApiResponseServiceProvider::class,
            ]
        );
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ApiResponseFacade' => ApiResponseFacade::class,
        ];
    }

    /**
     * @see https://github.com/staudenmeir/eloquent-eager-limit
     */
    protected function defineDatabaseMigrations(): void
    {
        // (require __DIR__.'/migrations/create_tables.php')->up();
        $this->loadMigrationsFrom(__DIR__.'/Laravel/migrations');
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed(TablesSeeder::class);
    }

    protected function defineEnvironment($app): void
    {
        // config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        config()->set('database.default', 'testing');
    }

    protected function defineRoutes($router): void
    {
        $router->any('exception', static function (): void {
            config()->set('app.debug', false);

            throw new \RuntimeException('This is a runtime exception.');
        })->middleware(SetAcceptHeader::class);

        $router->any('debug-exception', static function (): void {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            app(ExceptionHandler::class)->renderable(app(ApiPathsRenderUsing::class, ['only' => ['*']]));
            config()->set('app.debug', true);

            throw new \RuntimeException('This is a runtime exception.');
        });
    }
}
