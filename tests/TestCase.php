<?php

/** @noinspection PhpMissingDocCommentInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Tests;

use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Guanguans\LaravelApiResponse\Middleware\SetJsonAcceptHeader;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Guanguans\LaravelApiResponse\ServiceProvider;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\seeders\TablesSeeder;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ApiResponseFactory;
    use Faker;
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        // \DG\BypassFinals::enable();
        $this->app->useLangPath(__DIR__.'/Laravel/lang');
        $this->startMockery();
        JsonResource::wrap(collect([null, 'data'])->random());
    }

    protected function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ApiResponseFacade' => ApiResponseFacade::class,
        ];
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            ...parent::getPackageProviders($app),
        ];
    }

    protected function defineEnvironment($app): void
    {
        // config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        config()->set('database.default', 'testing');
        config()->set('mail.default', 'log');
    }

    /**
     * @see https://github.com/staudenmeir/eloquent-eager-limit
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Laravel/migrations');
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed(TablesSeeder::class);
    }

    protected function defineRoutes($router): void
    {
        $router->any('api/exception', static function (): void {
            config('api-response.render_using', ApiPathsRenderUsing::make());

            throw new \RuntimeException('This is a runtime exception.', Response::HTTP_BAD_GATEWAY);
        })->middleware(SetJsonAcceptHeader::class);
    }
}
